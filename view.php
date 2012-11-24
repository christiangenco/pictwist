<?php INCLUDE 'include/head.php'; ?>

<?php	
	if(isset($_POST['p_id']) || $_SESSION['img'])
	{
		if(isset($_POST['p_id']))
		{
			$pid = $_POST['p_id'];
			$_SESSION['img'] = $pid;
		}
		else {$pid = $_SESSION['img'];}
		
		$con = mysql_connect("localhost", "pictwist", 'secret');
		if(!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
	    
		mysql_select_db("pictwist", $con)
		    or die("Unable to select database: " . mysql_error());
		    
		$query = "select title, path from photos where id='$pid';";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$path = $row[path];
		$title = $row[title];
		
		$query = "select text, c.updated_at, p.id from photos p JOIN comments c where p.id = '$pid' AND p.id = 'c.photo_id' order by c.updated_at desc;";
		$result_comments = mysql_query($query);
		$query = "select text, t.updated_at, p.id, type from photos p JOIN tags t where p.id = '$pid' AND p.id = 't.photo_id' order by t.type desc;";
		$result_tags = mysql_query($query);
		
	}
	else
	{
		$_SESSION['error'] = 'You must select a photo to view!';
		header('Location: ' . $error); 
	}
?>
	<div>
	<div class="pic" ><!--style="float:top; float:left; padding:50px;"-->
		<img src="<?php echo $path;?>" alt="pic">
		<p><?php echo $title ?></p>
	</div>
	<div class="tags" ><!--style="float:top; float:left; padding:50px;"-->
		<?php
			while($row = mysql_fetch_array($result_tags))
			{
				echo '<div class="tag">'.
					$row[type] . ': ' . $row[text] .
					'</div>';
			}
			if($currentUser['id'] > 0)
			{
				echo '<form method="post" action="' . $tag_processor . '">'.
					'type:'.
					'<select name="tag">'.
					'<option value="location">Location</option>'.
					'<option value="camera type">Camera Type</option>'.
					'<option value="color">Color</option>'.
					'<option value="keyword">Keyword</option>'.
					'<option value="person">Person</option>'.
					'</select>'.
					'<br/>'.
					'tag: <input type="text" name="tag" value="tag"><br/>'.
					'<input type="submit" value="Create Tag">'.
					'</form><br/>';
			}
		?>
	</div>
	<div class="comments" ><!--style="float:left; clear:both; padding:0px 0px 0px 50px;"-->
		<?php
			while($row = mysql_fetch_array($result_comments))
			{
				echo '<div class="comment">'.
					$row[id] . ' said ' . $row[text] . '<br/>'.
					'date: ' . $row[updated_at] .
					'</div>';
			}
			if($currentUser['id'] > 0)
			{
				echo '<form method="post" action="' . $comment_processor . '">'.
					'<input type="text" name="tag" value="comment here..."><br/>'.
					'<input type="submit" value="Submit Comment">'.
					'</form>';
			}
		?>
	</div>
</div>

<?php INCLUDE 'include/foot.php' ?>