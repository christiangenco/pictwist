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
<?php
	date_default_timezone_set('America/Chicago');
	if(isset($currentUser['id']) && $currentUser['id'] > 0)
	{
		$uid = $currentUser['id'];
		//echo "ID is: " . $uid;
		connectToDb();
		$query = mysql_query("SELECT id, created_at, name, city, state, country, bio, updated_at FROM users WHERE id='$uid';");
		//echo "<br> QUERY: " . $query;
		$row = mysql_fetch_array($query);
	
		$id = $row['id'];
		$tstamp = $row['created_at'];
		$lastUpdate = $row['updated_at'];
		$name = $row['name'];
		$city = $row['city'];
		$state = $row['state'];
		$country = $row['country'];
		$bio = $row['bio'];
		//echo "timestamp: " . $tstamp;
		
		//echo "Member since " . date("m.d.y", strtotime($tstamp));                         // 10.05.08
		echo "<br><b>Name: </b>" . $name;
		if(!empty($city))
		{
			echo "<br><b>City: </b>" . $city;	
		}
		if(!empty($state))
		{
			echo "<br><b>State: </b>" . $state;
		}
		if(!empty($country))
		{
			echo "<br><b>Country: </b>" . $country;	
		}
		if(!empty($bio))
		{
			echo "<br><b>About me: </b>" . $bio;
		}		
		echo "<br><b>Member since </b>" . date("F j, Y", strtotime($tstamp));
		echo "<br><b>Last login was </b>" . date("F j, Y", strtotime($lastUpdate)); 
		//echo date('\I\t \i\s \t\h\e jS \d\a\y \s\i\n\c\e \r\e\g\i\s\t\r\a\t\i\o\n\!\.', strtotime($tstamp));   // It is the 5th day.

	}
	//$query2 = "SELECT name, email, created_at";

?>
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
        $query2 = "select a.id, a.title from albums a join shared on $uid = shared.user_id and shared.album_id = a.id;";
        $shared_albums = sql($query2);
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
                while($row = mysql_fetch_array($shared_albums))
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
