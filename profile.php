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
</head>
<?php INCLUDE_ONCE 'include/headBody.php' ?>

<?php
	connectToDb();
	$query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result))
	{
		echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '">'.
			'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
	}
?>
		
<?php INCLUDE 'include/foot.php' ?>	