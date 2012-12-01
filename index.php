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
	$query = "select title, id, album_id, path, created_at from photos order by created_at desc limit 0, 20;";
	$result = mysql_query($query);
	echo '<p>Recently Uploaded</p><br/>';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}

	$query = "select title, id, album_id, views, path, created_at from photos order by views desc limit 0, 20;";
	$result = mysql_query($query);
	echo '<p>Most Viewed</p><br/>';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}

	$query = "select p.id, p.title, p.album_id, f.user_id, path, p.created_at from photos p JOIN favorites f WHERE p.id = f.photo_id GROUP BY p.id order by count(*) desc limit 0, 20;";
	$result = mysql_query($query);
	echo '<p>Most Favorited</p><br/>';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}

	if(isLoggedIn())
	{
		$query = "select p.id, p.title, p.album_id, s.user_id, path, p.created_at from photos p JOIN albums a JOIN shared s WHERE p.album_id = a.id AND s.album_id = a.id AND s.user_id = ".$currentUser['id']." order by created_at desc limit 0, 20;";
		$result = mysql_query($query);
		echo '<p>Recently Shared with Me</p><br/>';
		while($row = mysql_fetch_array($result))
		{
			echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
				'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
		}


		$query = "select p.id, p.title, p.album_id, s.user_id, path, p.created_at from photos p JOIn albums a JOIN subscribes s WHERE p.album_id=a.id AND s.user_id_subscriber=1 AND a.user_id=s.user_id order by p.created_at desc limit 0, 20;";
		$result = mysql_query($query);
		echo '<p>My Subscriptions</p><br/>';
		while($row = mysql_fetch_array($result))
		{
			echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
				'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
		}
	}
?>
</div>
		
<?php INCLUDE 'include/foot.php' ?>	