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

			$('#currentPhoto').click();
			//alert("leaving...");
		});
	</script>
</head>
<?php INCLUDE_ONCE 'include/headBody.php' ?>

<?php
	connectToDb();

	errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), "Error! No photo selected.", $profileURL);
	// select current info
	// select parent id
	$query = "SELECT title, id, path, album_id, parent_photo_id FROM Photos WHERE id = ".$_REQUEST['p_id'].";";
	$result_current = sql($query);

	if($row = mysql_fetch_array($result_current))
	{
		$current_photo = array(
			"p_id" => $row['id'],
			"title" => $row['title'],
			"path" => $row['path'],
			"parent_id" => $row['parent_photo_id'],
			"a_id" => $row['album_id']
		);
	}
	// select parent info
	if(isset($current_photo['parent_id']))
	{
		$query = "SELECT title, id, path, album_id FROM Photos WHERE id = ".$current_photo['parent_id'].";";
		$result_parent = sql($query);	
		if($row = mysql_fetch_array($result_parent))
		{
			$parent_photo = array(
				"p_id" => $row['id'],
				"title" => $row['title'],
				"path" => $row['path'],
				"a_id" => $row['album_id']
			);
		}
	}

	echo "<p>Parent Photo</p>";
	if(isset($parent_photo['p_id']))
	{
		echo '<a id="' . $parent_photo[p_id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $parent_photo[p_id] . '&a_id=' . $parent_photo[a_id] . '">'.
		'<img src="'.$parent_photo[path].'" height=100 width=100 alt="'.$parent_photo[title].'"></a>';	
	}
	else
	{
		echo "<p>This is the original photo</p>";
	}

	echo "<br/><p>Current Photo</p>";
	echo '<a id="currentPhoto" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $current_photo[p_id] . '&a_id=' . $current_photo[a_id] . '">'.
		'<img src="'.$current_photo[path].'" height=100 width=100 alt="'.$current_photo[title].'"></a>';

	// select child ids
	// select child info
	$query = "SELECT id, title, path FROM Photos WHERE parent_photo_id = ".$_REQUEST['p_id'].";";
	$result_children = sql($query);

	echo "<br/><p>Child Photos</p>";
	while($row = mysql_fetch_array($result_children))
	{
		$child_photo = array(
			"p_id" => $row['id'],
			"title" => $row['title'],
			"path" => $row['path'],
			"a_id" => $row['album_id']
		);

		//display children
		echo '<a id="' . $child_photo[p_id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $child_photo[p_id] . '&a_id=' . $child_photo[a_id] . '">'.
		'<img src="'.$child_photo[path].'" height=100 width=100 alt="'.$child_photo[title].'"></a>';
	}
	if(!isset($child_photo['p_id']))
	{
		echo "<p>There are no children</p>";
	}		
	/*
	$query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
	$result = mysql_query($query);
	// display parent info
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}
	*/

	// display current info

	//display child info
?>
		
<?php INCLUDE 'include/foot.php' ?>	