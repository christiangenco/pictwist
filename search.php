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
	if(isset($_REQUEST['query']) && trim($_REQUEST['query']) !== "")
	{
		$query = "SELECT id, title, path, album_id from photos WHERE";

		if($_REQUEST['query'][0] == '#')
		{
			$counter = 0;
			$adv_search = $_REQUEST['query'];
			$adv_search = substr($adv_search, 1);
			$search_tag = (explode("#", $adv_search));
			
			if($currentUser['admin'] == FALSE)
			{
				foreach ($search_tag as $index => $tags) {
				$search_seg = (explode(":", $tags));
				$tag = trim($search_seg[0]);
				$search_query = (explode(" ", $search_seg[1]));
				if($tag == "tags")
				{
					foreach ($search_query as $key => $q) {
						if($q != "" && $q != " ")
						{
							if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
							    $query = $query . " OR ";
							}
							$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t JOIN albums a LEFT JOIN shared s ON a.id=s.album_id"
							." WHERE p.id = t.photo_id AND p.album_id = a.id AND (t.text LIKE '%".$q."%') AND"
							." ((p.private=0 AND a.private=0) OR"
							." ".$currentUser['id']." = a.user_id OR"
							." ".$currentUser['id']." = s.user_id)"
							." GROUP BY p.id"
							." ORDER BY count(p.id) desc))";
							$counter++;
						}
					}

				//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
				//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
				}
				else if($tag == "description")
				{
					foreach ($search_query as $key => $q) {
						if($q != "" && $q != " ")
						{
							if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
							    $query = $query . " OR ";
							}
							$query = $query . " (id IN (SELECT p.id FROM photos p JOIN albums a LEFT JOIN shared s ON a.id=s.album"
							." WHERE p.album_id = a.id AND (p.description LIKE '%".$q."%') AND"
							." ("
							." (p.private=0 AND a.private=0) OR"
							." ".$currentUser['id']." = a.user_id OR"
				     		." ".$currentUser['id']." = s.user_id"
							." )"
							." GROUP BY p.id"
							." ORDER BY count(p.id) desc))";
							$counter++;	
						}
					}
				}
				else if($tag == "title")
				{
					foreach ($search_query as $key => $q) {
						if($q != "" && $q != " ")
						{
							if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
							    $query = $query . " OR ";
							}
							$query = $query . " (id IN (SELECT p.id FROM photos p JOIN albums a LEFT JOIN shared s ON a.id=s.album_id"
							." WHERE p.album_id = a.id AND (p.title LIKE '%".$q."%') AND"
							. " ("
							." (p.private=0 AND a.private=0) OR"
							." ".$currentUser['id']." = a.user_id OR"
							." ".$currentUser['id']." = s.user_id"
							." )"
							." GROUP BY p.id"
							." ORDER BY count(p.id) desc))";
							$counter++;	
						}
					}
				}
				else
				{
						foreach ($search_query as $key => $q) {
						//echo '<p>adv: '.$adv_search.' s_tag: '.$search_tag.' s_seg: '.$search_seg.' tag: '.$tag.' q:'.$q.' </p>';
						//echo '<br/>pre-subquery:<br/>' . $query . '<br/><br/>';
							if($q != "" && $q != " ")
							{
								if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
								    $query = $query . " OR ";
								}	
								$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t  JOIN albums a LEFT JOIN shared s ON a.id=s.album_id"
								." WHERE p.album_id = a.id AND p.id = t.photo_id AND t.type = '". $tag ."' AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%') AND"
								." ("
								." (p.private=0 AND a.private=0) OR"
								." ".$currentUser['id']." = a.user_id OR"
								." ".$currentUser['id']." = s.user_id"
								." )"
								." GROUP BY p.id"
								." ORDER BY count(p.id) desc))";
								$counter++;	
							}
						//echo '<br/>post-subquery:<br/>' . $query . '<br/><br/>';

						//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
						//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
						}
					}
				/*
				if(end($search_tag) !== $tags){
					    $query = $query . " OR ";
				}
				*/
				}
			}

			else
			{
				echo "<br/>admin<br/>";
				foreach ($search_tag as $index => $tags) {
					$search_seg = (explode(":", $tags));
					$tag = trim($search_seg[0]);
					$search_query = (explode(" ", $search_seg[1]));
					if($tag == "tags")
					{
						foreach ($search_query as $key => $q) {
							if($q != "" && $q != " ")
							{
								if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
								    $query = $query . " OR ";
								}
								$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t"
								." WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%')"
								." GROUP BY p.id"
								." ORDER BY count(p.id) desc))";
								$counter++;
							}
						}

					//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
					//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
					}
					else if($tag == "description")
					{
						foreach ($search_query as $key => $q) {
							if($q != "" && $q != " ")
							{
								if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
								    $query = $query . " OR ";
								}
								$query = $query . " (id IN (SELECT p.id FROM photos p"
								." WHERE (p.description LIKE '%".$q."%')"
								." GROUP BY p.id"
								." ORDER BY count(p.id) desc))";
								$counter++;	
							}
						}
					}
					else if($tag == "title")
					{
						foreach ($search_query as $key => $q) {
							if($q != "" && $q != " ")
							{
								if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
								    $query = $query . " OR ";
								}
								$query = $query . " (id IN (SELECT p.id FROM photos p"
								." WHERE (p.title LIKE '%".$q."%')"
								." GROUP BY p.id"
								." ORDER BY count(p.id) desc))";
								$counter++;	
							}
						}
					}
					else
					{

							foreach ($search_query as $key => $q) {
							//echo '<p>adv: '.$adv_search.' s_tag: '.$search_tag.' s_seg: '.$search_seg.' tag: '.$tag.' q:'.$q.' </p>';
							//echo '<br/>pre-subquery:<br/>' . $query . '<br/><br/>';
							if($q != "" && $q != " ")
							{
								if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
								    $query = $query . " OR ";
								}	
								$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t"
								." WHERE p.id = t.photo_id AND t.type = '". $tag ."' AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%')"
								." GROUP BY p.id"
								." ORDER BY count(p.id) desc))";
								$counter++;	
							}
							//echo '<br/>post-subquery:<br/>' . $query . '<br/><br/>';

							//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
							//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
						}
					}
					/*
					if(end($search_tag) !== $tags){
						    $query = $query . " OR ";
					}
					*/
				}
			}
		
		}
		else
		{
			//echo '<p>'.$_REQUEST['query'].'</p>';
			$search_query = (explode(" ",$_REQUEST['query']));
			$counter = 0;
			foreach ($search_query as $key => $q) {
				$q = trim($q);
				
				if($q != "" && $q != " ")
				{
					if($counter > 0){//start($search_query) !== $q || first($search_query) === " "){
					    $query = $query . " OR ";
					}
					//echo '<br/>pre-subquery:<br/>' . $query . '<br/>k: ' . $q . '<br/>';
					if(!$currentUser['admin'])
					{
						$query = $query . " (id IN (SELECT p.id FROM photos p LEFT JOIN tags t ON p.id = t.photo_id JOIN albums a LEFT JOIN shared s ON a.id=s.album_id"
										." WHERE p.album_id = a.id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%' OR p.description LIKE '%".$q."%') AND"
										." ("
										." (p.private=0 AND a.private=0) OR"
										." ".$currentUser['id']." = a.user_id OR"
										." ".$currentUser['id']." = s.user_id"
										." )"
										." GROUP BY p.id"
										." ORDER BY count(p.id) desc))";
					}

					else
					{
						echo "<br/>admin<br/>";
						$query = $query . " (id IN (SELECT p.id FROM photos p LEFT JOIN tags t ON p.id = t.photo_id"
						." WHERE (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%' OR p.description LIKE '%".$q."%')"
						." GROUP BY p.id"
						." ORDER BY count(p.id) desc))";
					}
					//echo '<br/>post-subquery:<br/>' . $query . '<br/><br/>';
					$counter++;
				}
			}
		}

		$query = $query . " GROUP BY id ORDER BY views desc;";
		//echo $query . '<br/>';
		//echo $query . '<br/><br/>';
		$result_search = sql($query);
			while($row = mysql_fetch_array($result_search))
			{
				echo '<a id="' . $row[id] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
					'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
			}
	}
	else
	{
		redirect($profileURL);
	}
?>
		
<?php INCLUDE 'include/foot.php' ?>	