<?php INCLUDE_ONCE 'include/head.php'; ?>

<?php
    connectToDb();

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        $a_id = $_GET['album_id'];
        $sql = "SELECT title from albums where id=$a_id;";
        $result = sql($sql);
        $title = mysql_fetch_array($result);
        $query = "select id, title from photos where album_id='".$a_id."';";
        $result_photos = sql($query);
    }
    /*
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
            redirect($logoutURL);
    } 
    */
?>

<script type="text/javascript">
	setTitle("Album - <?php echo $title['title'] ?>");
</script>



 
<a class="returnLink" href="<?php echo $profileURL;?>">< Back to my profile</a>
   

    <?php
        $query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = $a_id AND a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
        $result = sql($query);
    
        echo '<div class="imageList_title">'.$title['title'].'</div><div class="imageList">';
        while($row = mysql_fetch_array($result))
        {
            echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $a_id . '">'.
                '<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
        }
            echo '</div>';
    ?>
     
<div class="divider"></div>	 
	 
<div class="centerAlign">	 

	<a class="m-btn blue thinBorder" href="<? echo $uploadURL ?>"><i class="icon-plus icon-white"></i> Add Photo</a>

	<a class="m-btn blue thinBorder" href="<?php echo $baseURL . 'album.editor.php?album_id=' . $a_id ?>"><i class="icon-pencil icon-white"></i> Edit Album</a>	 

	<a id="showShareAlbum" class="m-btn blue thinBorder" href="javascript:;"><i class="icon-share icon-white"></i> Share Album</a>	 

	<div id="shareAlbum">
		<div class="formContainer">
		<form action="<?php echo $baseURL . 'album.share.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
		
				<div class="centerAlign"><h4>Enter one</h4></div>
			
				<div class="m-input-prepend">
					<span class="add-on"><label for="User">Name: </label></span>
					<input class="m-wrap" id="user" type="text" name="username">
				</div>				
				<div class="centerAlign"><h4>OR</h4></div>
				<div class="m-input-prepend">
					<span class="add-on"><label for="User">Email:</label> </span>
					<input class="m-wrap" id="user" type="text" name="useremail">
				</div>				

				<input class="m-btn blue thinBorder" type="submit" name="ShareAlbum" value="Share" />
				
				
		</form>
		</div>
	</div>
</div>

<?php INCLUDE 'include/foot.php' ?> 