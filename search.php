<?php INCLUDE 'include/head.php'; ?>

<?php
	connectToDb();
	if(isset($_REQUEST['query']) && trim($_REQUEST['query']) !== "")
	{
		$query = "SELECT id, title, path from photos WHERE";

		if($_REQUEST['query'][0] == '#')
		{
			$counter = 0;
			$adv_search = $_REQUEST['query'];
			$adv_search = substr($adv_search, 1);
			$search_tag = (explode("#", $adv_search));
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

					$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t"
					." WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%' OR p.description LIKE '%".$q."%')"
					." GROUP BY p.id"
					." ORDER BY count(p.id) desc))";
					//echo '<br/>post-subquery:<br/>' . $query . '<br/><br/>';
					$counter++;
				}
			}
		}

		$query = $query . " GROUP BY id ORDER BY views desc;";
		//echo $query . '<br/><br/>';
		$result_search = sql($query);
			while($row = mysql_fetch_array($result_search))
			{
				echo '<a id="' . $row[id] . '" href="'.$viewLightBoxURL.'?p_id=' . $row[id] . '">'.
					'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a>';
			}
	}
	else
	{
		redirect($profileURL);
	}
?>
		
<?php INCLUDE 'include/foot.php' ?>	