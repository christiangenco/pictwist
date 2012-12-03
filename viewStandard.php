<?php INCLUDE_ONCE 'include/head.php' ?>

<?php
	connectToDb();
	errorRedirect(isRestrictedPhoto($_REQUEST['p_id'], $_REQUEST['a_id']), "Error! You do not have permission to view this photo.", $indexURL);
   	
    /*
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    */
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), 'Error! You need to select a photo to edit.', $indexURL);
    $photo_id = params('p_id');
    $album_id = params('a_id');

    // ######## add to views.php!!!!
    $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
    //echo $query . "<br/><br/>";
    $result = sql($query);
    $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
    //echo $query . "<br/><br/>";
    $result_photo = sql($query);
    while($row = mysql_fetch_array($result_photo))
    {
        $photo_title = $row["title"];
        $pathname = $row["path"];
        $private = $row['private'];
        $album_id = $row["album_id"];
        $description = $row["description"];
    }
    $query = "select id, type, text from tags where photo_id = '".$photo_id."';";
    //echo $query . "<br/><br/>";
    $result_tags = sql($query);
    $query = "select text, c.id, c.updated_at, u.name from photos p JOIN comments c JOIN users u where p.id = ".$photo_id." AND p.id = c.photo_id AND u.id = c.user_id order by c.updated_at desc;";
    //echo $query . "<br/><br/>";
	//echo $query . '<br/><br/>';
	$result_comments = sql($query);
    
    
?>

<script type="text/javascript">
	setTitle("<?php echo $photo_title;?>");
</script>

<div class="bigPhoto" >
	<div class="photoTitle"><?php echo $photo_title;?>
	
	<?php 
			if (isFavorite($photo_id)) {
				echo '<span class="isFavorited"><i class="star"></i> Favorite</span>';
			}
		?>
		
	</div>
	<img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>">		

	<div class="photoInfo">		
		<div class="photoDesc">
		<?php 
			if (strlen($description) > 0) {
				echo $description;
			} else {
				echo '<span class="noDesc">no description</span>';
			}
		?>
		</div>	
		<div id="tags">
			Tags (click to remove):
			<?php
				while($row = mysql_fetch_array($result_tags))
				{
					echo '<div class="tagContainer"><a class="m-btn mini rnd tag" href='.$deleteTagURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&t_id='.$row['id'].'>';
					
					if ($row["type"] != "keyword") {
						echo $row["type"].': ';
					}
					echo $row["text"].'</a>';
					echo '<a class="flagBtn" href='.$flagContentURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&t_id='.$row['id'].'></a>';
					echo '</div>';
				}
			?>
			<a href="javascript:;" id="showAddTags" class="m-btn mini rnd tag"><i class="icon-plus"></i></a>
			
			<div id="addTags">
				<form id="addTagsForm" action="<?php echo $viewHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id ?>" enctype="multipart/form-data" method="post">
				<select class="m-wrap m-ctrl-small" name='tag'>
					<option value='keyword'>Keyword</option>
					<option value='location'>Location</option>
					<option value='person'>Person</option>
				</select>
				<span class="m-input-append">
					<input type='text' class="m-wrap m-ctrl-small" name='tagContent' rows="1" cols="10" placeholder='Enter a tag'>
					<a id="addTagBtn" href="javascript:;" class="m-btn icn-only black"><i class="icon-plus icon-white"></i></a>
				</span>
				</form>
			</div>
			
		</div>			
		<div id="photoOptions">
			<div class="m-btn-group">
				<?php
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$editURL.'?p_id='.$photo_id.'&a_id='.$album_id . '">'.
					'<i class="icon-pencil"></i> Edit Photo</a>';
				if (isFavorite($photo_id)) {	
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$favoriteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'<i class="icon-star-empty"></i> Remove Favorite</a>';
			} else {
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$favoriteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'<i class="icon-star"></i> Add Favorite</a>';
			}
				echo '<a class="m-btn blue" id="' . $photo_id . '" href="'.$twistURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'Twist!</a>';
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$twistHistoryURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'<i class="icon-time"></i> View Twist History</a>';
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$deleteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'<i class="icon-trash"></i> Delete Photo</a>';
				echo '<a class="m-btn" id="' . $photo_id . '" href="'.$flagContentURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'<i class="icon-flag"></i> Flag Photo</a>';
				?>
			</div>
		</div>							
		
	</div> 	
	
	
	<div class="comments">
		<?php
			while($row = mysql_fetch_array($result_comments))
			{
				echo '<div class="comment">';
				echo '<div class="comment_user">'.$row["name"].'</div><div class="comment_time">'.$row["updated_at"].'</div>';
				echo '<div class="comment_body">'.$row["text"];
				echo '<a href="'.$deleteCommentURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&c_id='.$row["id"].'"><i class="deleteCommentBtn"></i></a>';//removed a div tag here...
				echo '<a href="'.$flagContentURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&c_id='.$row["id"].'"><i class="flagCommentBtn"></i></a></div>';
				echo '</div>';
			}
		?>
	</div>
	
	<div id="commentForm">
		<?php
		if($currentUser['id'] > 0)
		{
			echo '<form method="post" action="' . $viewHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
				'<textarea class="m-wrap" type="textarea" name="comment" rows="2" placeholder="Add a comment"></textarea><br/>'.
				'<input class="m-btn thinBorder_light" type="submit" name="submit" value="Submit Comment">'.
				'</form>';
		}
		?>
	</div>


</div>

<?php INCLUDE_ONCE 'include/foot.php' ?>