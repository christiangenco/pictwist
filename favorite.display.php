<?php INCLUDE_ONCE 'include/head.php'; ?>

<?php
    connectToDb();

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        //$_SESSION['a_id'] = $_REQUEST['album_id'];
        //$a_id = $_REQUEST['album_id'];
        //$sql = "SELECT title from albums where id=$a_id;";
        //$album_title = mysql_fetch_row(sql($sql));
        
        $query = "SELECT p.id, p.title, p.path, p.album_id from photos p JOIN albums a JOIN favorites f WHERE p.album_id=a.id AND p.id=f.photo_id AND f.user_id=".$currentUser['id'].";";
        //echo $query;
        $result = mysql_query($query);
        echo '<div class="imageList_title">My Favorites</div><div class="imageList">';
        while($row = mysql_fetch_array($result))
        {
            echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
                '<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
        }
        echo '</div>';
        //$query = "select id, title from photos where album_id='".$a_id."';";
        //$result_photos = sql($query);
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
            redirect($logoutURL);
    } 
?>

<script type="text/javascript">
	setTitle("Album - My Favorites");
</script>

<form id="AlbumPhotos" action="<?php echo $baseURL . 'album.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        <?//php echo $row[title] ?>
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
 
</form>


<?php INCLUDE 'include/foot.php' ?> 
