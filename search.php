<?php INCLUDE 'include/head.php'; ?>

<?php
	connectToDb();
	if(isset($_POST['query']))
	{
		$query = "SELECT id, path from photos WHERE";

		if($_POST['query'][0] == '#')
		{
			$adv_search = $_POST['query'];
			$adv_search = substr($adv_search, 1);
			$search_tag = (explode("#", $adv_search));
			foreach ($search_tag as $index => $tags) {
				$search_seg = (explode(":", $tags));
				$tag = $search_seg[0];
				$search_query = (explode(" ", $search_seg[1]));

				foreach ($search_query as $key => $q) {
					//echo '<p>adv: '.$adv_search.' s_tag: '.$search_tag.' s_seg: '.$search_seg.' tag: '.$tag.' q:'.$q.' </p>';
					$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t"
					." WHERE p.id = t.photo_id AND t.type = '". $tag ."' AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%')"
					." GROUP BY p.id"
					." ORDER BY count(p.id) desc))";
					if(end($search_query) !== $q){
					    $query = $query . " OR ";
					}
					//echo '<br/><br/>' . $query . '<br/><br/>';

					//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
					//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
				}
				if(end($search_tag) !== $tags){
					    $query = $query . " OR ";
				}
			}
		
		}
		else
		{
			//echo '<p>'.$_POST['query'].'</p>';
			$search_query = (explode(" ",$_POST['query']));

			foreach ($search_query as $key => $q) {
				$query = $query . " (id IN (SELECT p.id FROM photos p JOIN tags t"
				." WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%')"
				." GROUP BY p.id"
				." ORDER BY count(p.id) desc))";
				if(end($search_query) !== $q){
				    $query = $query . " OR ";
				}

				//$query = "select DISTINCT p.id, p.path from photos p JOIN tags t WHERE p.id = t.photo_id AND (t.text LIKE '%".$q."%' OR p.title LIKE '%".$q."%');";
				//echo '<p>~~~~~~~~~~~~~~~~~~~~~~~~~~~</p>';
			}
		}

		$query = $query . " GROUP BY id ORDER BY views desc;";
		//echo $query . '<br/>';
		$result_search = sql($query);
			while($row = mysql_fetch_array($result_search))
			{
				echo '<form id="' . $row[id] . '" action ="'.$editURL.'" method="post">'.
					'<input type="hidden" name="p_id" value="'.$row[id].'">'.
					'<img src="'.$row[path].'" alt="pic" style="cursor:pointer;" onclick="document.getElementById(' . $row[id] . ').submit();"></form>';
			}
	}
	else
	{
		redirect($profileURL);
	}
?>
		
<?php INCLUDE 'include/foot.php' ?>	