<?php INCLUDE 'include/head.php';?>

<?php    
    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        connectToDb();
        $uid = $currentUser['id'];
    }
    else
    {
        $_SESSION['error'] = 'Error! You must be logged in to view your albums!';
        redirect($logoutURL);
    }

    function album_html($album_id, $album_title, $albumURL, $first_photo_path, $photo_urls){
        return <<<EOT
        <div class='album' style='float:left; margin: 20px;'>
        <a href='$albumURL?album_id=$album_id'><h3>$album_title</h3></a>
        <!--<a href='uploadURL?a_id=album_id'>add photos</a>-->

        <a href="$albumURL?album_id=$album_id">
        <div style="width: 200px; height: 200px; border: 1px solid black; border-radius: 20px;">
            <img src="$first_photo_path" alt="" id="album_$album_id" style="max-width: 200px; max-height: 200px; border-radius: 20px" />
        </div>
        </a>
        <script type="text/javascript">
        var array = [
            $photo_urls
        ];
        $("#album_$album_id").iskip({images:array, method:'mousemove', 'cycle':3});
        </script>
        </div>
EOT;
    }

    function display_album($album_id){
        global $uploadURL;
        global $albumURL;

        $album_id = escape($album_id);
        $album = mysql_fetch_array(sql("select * from albums where id=".$album_id));

        $photos_raw = sql("select photos.* from albums left join photos on albums.id = photos.album_id where albums.id=".$album_id);
        $photos = array();
        $photo_urls = "";
        while($photo = mysql_fetch_array($photos_raw)){
            array_push($photos, $photo);
            $photo_urls = $photo_urls.",'".$photo['path']."'";
        }

        $first_photo_path = $photos[0]['path']; // because php sucks
        $album_title = $album['title']; //because php sucks

        echo album_html($album_id, $album_title, $albumURL, $first_photo_path, $photo_urls);
    }
?>
<script src="js/jquery.iskip.js"></script>

<form id="EditAlbums" action="<?php echo $baseURL . 'album.editor.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Albums
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php

            // favorites
            $result = sql("SELECT * from photos p JOIN albums a JOIN favorites f WHERE p.album_id=a.id AND p.id=f.photo_id AND f.user_id=".escape($currentUser['id'])." order by p.created_at desc");

            $photo_urls = "";
            while($photo = mysql_fetch_array($result))
            {
                if(!isset($first_photo_path)) $first_photo_path = $photo["path"];
                $photo_urls = $photo_urls.",'".$photo['path']."'";
            }
            $album_id = "favorites";
            $album_title = "Favorites";
            echo album_html($album_id, $album_title, $favoriteDisplayURL, $first_photo_path, $photo_urls);

            $users_albums = sql("select id, title from albums where user_id='".$uid."';");
	        while($album = mysql_fetch_array($users_albums))
                display_album($album["id"]);
        ?>
    </p> 
 
</form>

<form id="AddAlbum" action="<?php echo $baseURL . 'album.processor.php' ?>" method="post">
<div style="clear: both;"></div>

<h2>
    New Album
</h2>

<p>
    <label for="title">Title:</label> 
    <input type="text" name="title">
</p>

<p>
    Private: 
    <input type="checkbox" name="private" value="1" />
</p>

<p>
    <input type="submit" name="AlbumSubmit" value="Create Album" />
</p>

</form>

<?php INCLUDE 'include/foot.php' ?>