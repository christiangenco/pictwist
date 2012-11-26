<?php INCLUDE 'include/head.php'; ?>

<?php
	$con = mysql_connect("localhost", "pictwist", 'secret');
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
    
	mysql_select_db("pictwist", $con)
	    or die("Unable to select database: " . mysql_error());
	$query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" href="'.$viewURL.'?p_id=' . $row[id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="pic"></a>';
	}
?>
		
<?php INCLUDE 'include/foot.php' ?>	