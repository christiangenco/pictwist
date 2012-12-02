<?php INCLUDE_ONCE 'include/head.php'; ?>




<?php
	connectToDb();
	$query = "select title, id, album_id, path, created_at from photos order by created_at desc limit 0, 20;";
	$result = mysql_query($query);
	
	echo '<div class="imageList_title">Recently Uploaded</div><div class="imageList">';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
			'<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
	}
		echo '</div>';

	$query = "select title, id, album_id, views, path, created_at from photos order by views desc limit 0, 20;";
	$result = mysql_query($query);
	
	echo '<div class="imageList_title">Most Viewed</div><div class="imageList">';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
			'<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
	}
		echo '</div>';

	$query = "select p.id, p.title, p.album_id, f.user_id, path, p.created_at from photos p JOIN favorites f WHERE p.id = f.photo_id GROUP BY p.id order by count(*) desc limit 0, 20;";
	$result = mysql_query($query);
	
	echo '<div class="imageList_title">Most Favorited</div><div class="imageList">';
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
			'<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
	}
		echo '</div>';

	if(isLoggedIn())
	{
		$query = "select p.id, p.title, p.album_id, s.user_id, path, p.created_at from photos p JOIN albums a JOIN shared s WHERE p.album_id = a.id AND s.album_id = a.id AND s.user_id = ".$currentUser['id']." order by created_at desc limit 0, 20;";
		$result = mysql_query($query);
		echo '<div class="imageList_title">Recently Shared with Me</div><div class="imageList">';
		while($row = mysql_fetch_array($result))
		{
			echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
				'<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
		}
		echo '</div>';


		$query = "select p.id, p.title, p.album_id, s.user_id, path, p.created_at from photos p JOIn albums a JOIN subscribes s WHERE p.album_id=a.id AND s.user_id_subscriber=1 AND a.user_id=s.user_id order by p.created_at desc limit 0, 20;";
		$result = mysql_query($query);
		echo '<div class="imageList_title">My Subscriptions</div><div class="imageList">';
		while($row = mysql_fetch_array($result))
		{
			echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
				'<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
		}
		echo '</div>';
	}
?>

</div>
		
<?php INCLUDE 'include/foot.php' ?>	