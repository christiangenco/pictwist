<?php INCLUDE 'include/head.php'; ?>

<?php
	connectToDb();
	if(isset($_POST['query']))
	{
		//echo '<p>'.$_POST['query'].'</p>';
		$search_query = (explode(" ",$_POST['query']));
		
		$query = "SELECT id, path from photos WHERE";

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