<?php INCLUDE 'include/head.php';?>

<?php
    connectToDb();
    $query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
    $result = mysql_query($query);
    while($row = mysql_fetch_array($result))
    {
        echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '">'.
            '<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
    }

    if(isset($currentUser['id']) && $currentUser['id'] > 0 && isset($_REQUEST['album_id']))
    {
        $uid = $currentUser['id'];
        $a_id = $_REQUEST['album_id'];
        $sql = "SELECT title from albums where id=$a_id;";
        $album_title = mysql_fetch_row(sql($sql));
        
        $query = "select id, title from photos where album_id='".$a_id."';";
        $result_albums = sql($query);
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
            redirect($logoutURL);
    } 
?>

<form id="AlbumPhotos" action="<?php echo $baseURL . 'album.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        <?php echo $album_title['title'] ?>
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php
                while($row = mysql_fetch_array($result_albums))
                {
                        echo '<a href="view.php?album_id=' . $row[id] . '">' . $row[title] . '</a><br/>';
                }
        ?>

        <br/>
    </p> 
 
</form>

<form id="EditAlbum" action="<?php echo $baseURL . 'albums.php' ?>" enctype="multipart/form-data" method="post"> 
    <p>
        <input type="submit" name="EditAlbum" value="Edit Album" />
    </p>
</form>

<form id="ShareAlbum" action="<?php echo $baseURL . 'album.share.php' ?>" enctype="multipart/form-data" method="post"> 
    <h1> 
        Share Album 
    </h1> 

    <p> 
        <label for="User">Name of user with whom you would like to share the album:</label> 
        <input id="user" type="text" name="user">
    </p>
    <p>
        <input type="submit" name="ShareAlbum" value="Share Album" />
    </p>
</form>

<?php INCLUDE 'include/foot.php' ?> 
