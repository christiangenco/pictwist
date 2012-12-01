<?php INCLUDE_ONCE 'include/headCode.php'; ?>
<head>
<title>PicTwist</title>
	<?php INCLUDE_ONCE 'include/cssAndJsIncludes.php'; ?>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="fancyBox/source/jquery.fancybox.pack.js?v=2.1.3"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="fancyBox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
	<link href="styles/styles.css" rel="stylesheet" type="text/css">

	<script type="text/javascript">
		$(document).ready(function() {
			//alert("Hey there");
			$(".fancybox").fancybox();
			
			$(".fancybox-iframe").fancybox({
				
				type : 'iframe',
				prevEffect : 'fade',
				nextEffect : 'fade',
				openEffect : 'none',
				closeEffect : 'none',
				margin : [20, 60, 20, 60],				
				
				closeBtn : true,
				arrows : true,
				nextClick : false,
				
				helpers: {
					title : {
						type : 'inside'
					}
				},
				
				beforeShow: function() {
					this.width = 1000;
				}
				
			});
			//alert("leaving...");
		});
	</script>

		<form method="post" action="editinfo.php">
			<input type="submit" value="My Account">
		</form>
</head>
<?php INCLUDE_ONCE 'include/headBody.php' ?>
<div id="user info">

	
</div>
<div id="album info">
<?php
	connectToDb();
	$query = "select p.album_id, a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}

	if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        
        $query = "select id, title from albums where user_id='".$uid."';";
        $result_albums = sql($query);
        $query = "select a.id, a.title from albums a join shared on $uid = shared.user_id and shared.album_id = a.id;";
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your albums!';
            redirect($logoutURL);
    } 
    #move query to album.photos.php to display photos query shared albums needs to update
?>

<form id="MyAlbums" action="<?php echo $baseURL . 'album.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        My Albums 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php
                while($row = mysql_fetch_array($result_albums))
                {
                        echo '<a href="album.photos.php?album_id=' . $row[id] . '">' . $row[title] . '</a><br/>';
                }
            ?>

        <br/>
    </p>  
</form>

<form id="MySharedAlbums" action="<?php echo $baseURL . 'album.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        My Shared Albums 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php
                while($row = mysql_fetch_array($result_albums))
                {
                        echo '<a href="album.photos.php?album_id=' . $row[id] . '">' . $row[title] . '</a><br/>';
                }
            ?>

        <br/>
    </p> 
</form>

<form id="AddAlbum" action="<?php echo $baseURL . 'album.processor.php' ?>" method="post">
            <h2>
                Add an Album!
            </h2>

            <p>
                <label for="title">Album Title:</label> 
                <input type="text" name="title">
            </p>

            <p>
                Would you like this album to be private?
                <input type="checkbox" name="private" value="1" />
            </p>

            <p>
                <input type="submit" name="AlbumSubmit" value="Submit" />
            </p>

     </form>

</div>
		
<?php INCLUDE 'include/foot.php' ?>	