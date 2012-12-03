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
        $html = <<<EOT
        
		<div class='albumContainer'>
		<div class='albumTitle'><a href='$albumURL?album_id=$album_id'>$album_title</a>
EOT;
		if ($album_id == "favorites") {
			$html .= " <i class='star'></i>";
		}
		$html .= <<<EOT
		</div>
        <!--<a href='uploadURL?a_id=album_id'>add photos</a>-->

        <a href="$albumURL?album_id=$album_id">
			<div class="album">
				<div class="albumInner">
EOT;
		if (strlen($first_photo_path) > 0) {
			$html .= '<img src="'.$first_photo_path.'" id="album_'.$album_id.'" />';
		} else {
			$html .= '<span class="noPhoto">Empty</span>';
		}
				
		$html .= <<<EOT
				</div>
			</div>
        </a>
		
        <script type="text/javascript">
        var array = [
            $photo_urls
        ];
        $("#album_$album_id").iskip({images:array, method:'mousemove', 'cycle':1});
        </script>
		</div>
EOT;
		return $html;
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

<script type="text/javascript">
	setTitle("My Albums");
</script>

<a class="returnLink" href="<?php echo $profileURL;?>">< Back to my profile</a>

 
    <h1 class="inline"> 
       My Albums
    </h1> 
	
	<div id="albums_newAlbumContainer">
		<a id="albums_newAlbumToggle" class="m-btn thinBorder" href="javascript:;"><i class="icon-plus"></i> New Album</a>
		<span id="albums_newAlbum">		
		
			<form class="inline" id="AddAlbum" action="<?php echo $baseURL . 'album.processor.php' ?>" method="post">			
							
				<input class="m-wrap" type="text" name="title" placeholder="Album Name">
				<select class="m-wrap m-ctrl-small" name="private">
					<option>Public</option>
					<option value="1">Private</option>
				</select>
				<input class="m-btn blue thinBorder" type="submit" name="AlbumSubmit" value="Create Album" />
				
			</form>			
			
		</span>
	</div>
     
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
 

<?php INCLUDE 'include/foot.php' ?>