<?php INCLUDE_ONCE 'include/headCode.php';?>
<!DOCTYPE html>
<head>
<title>PicTwist</title>
	<?php INCLUDE 'include/cssAndJsIncludes.php';?>
</head>
<body>
<?php
	//echo "HERE";
    connectToDb();
    //$upload = false;
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), "Error! Not photo selected.", $profileURL);
    $photo_id = $_REQUEST['p_id'];
    $album_id = $_REQUEST['a_id'];
    errorRedirect(isRestrictedPhoto($_REQUEST['p_id'], $_REQUEST['a_id']), "Error! You do not have permission to view this photo.", $profileURL);
   
    /*
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    */
    if(!isset($photo_id))
    {
        $_SESSION['error'] = 'Error! You need to select a photo to edit.';
        $_SESSION['redirect'] = $profileURL;
        //redirect($errorURL);
        echo 'redirectParent(\''.$errorURL.'\');';
        //echo "parent.location.href = ".$errorURL.";";
    }
    else
    {
        // ######## add to views.php!!!!
        $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
        $result = sql($query);
        $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
        $result_photo = sql($query);
        if($row = mysql_fetch_array($result_photo))
        {
            $photo_title = $row["title"];
            $pathname = $row["path"];
            $private = $row['private'];
            $album_id = $row["album_id"];
            $description = $row["description"];
        }
        $query = "select id, type, text from tags where photo_id = '".$photo_id."';";
        $result_tags = sql($query);
        $query = "select text, c.id, c.updated_at, u.name from photos p JOIN comments c JOIN users u where p.id = ".$photo_id." AND p.id = c.photo_id AND u.id = c.user_id order by c.updated_at desc;";
		//echo $query . '<br/><br/>';
		$result_comments = sql($query);
    }
    
    
?>

<div class="bigPhoto" >
	<div class="bigPhotoContainer">
		<div class="photoTitle"><?php echo $photo_title;?></div>
		<div class="permalink"><a class="m-btn thinBorder_light" href="javascript:;" onclick="redirectParent('<?php echo $viewURL.'?p_id='.$photo_id.'&a_id='.$album_id?>');"><i class="icon-share"></i> Permalink</a></div>
		<img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>">
		
		<div class="photoDesc">
		<?php 
			if (strlen($description) > 0) {
				echo $description;
			} else {
				echo '<span class="noDesc">no description</span>';
			}
		?>
		</div>
	</div>

			
		
	<div id="tags">
		Tags (click to remove):
		<?php
			while($row = mysql_fetch_array($result_tags))
			{
				echo '<a class="m-btn mini rnd tag" href='.$deleteTagURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&t_id='.$row['id'].'>';
				if ($row["type"] != "keyword") {
					echo $row["type"].': ';
				}
				echo $row["text"].'</a></td>';
			}
		?>
		<a href="javascript:;" id="showAddTags" class="m-btn mini rnd tag"><i class="icon-plus"></i></a>
		
		<div id="addTags">
			<form action="<?php echo $viewHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id ?>" enctype="multipart/form-data" method="post">
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
			echo '<a class="m-btn" id="' . $photo_id . '" href="javascript:;" onclick="redirectParent(\''.$editURL.'?p_id='.$photo_id.'&a_id='.$album_id . '\');">'.
				'<i class="icon-pencil"></i> Edit Photo</a>';
			echo '<a class="m-btn" id="' . $photo_id . '" href="javascript:;" onclick="redirectParent(\''.$favoriteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '\');">'.
				'<i class="icon-heart"></i> Add Favorite</a>';
			echo '<a class="m-btn blue" id="' . $photo_id . '" href="javascript:;" onclick="redirectParent(\''.$twistURL.'?p_id='.$photo_id.'&a_id='.$album_id. '\');">'.
				'Twist!</a>';
			echo '<a class="m-btn" id="' . $photo_id . '" href="javascript:;" onclick="redirectParent(\''.$twistHistoryURL.'?p_id='.$photo_id.'&a_id='.$album_id. '\');">'.
				'<i class="icon-time"></i> View Twist History</a>';
			echo '<a class="m-btn" id="' . $photo_id . '" href="javascript:;" onclick="redirectParent(\''.$deleteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '\');">'.
				'<i class="icon-trash"></i> Delete Photo</a>';
			?>
		</div>
	</div>							
		

	
	
	<div class="comments">
		<?php
			while($row = mysql_fetch_array($result_comments))
			{
				echo '<div class="comment">';
				echo '<div class="comment_user">'.$row["name"].'</div><div class="comment_time">'.$row["updated_at"].'</div>';
				echo '<div class="comment_body">'.$row["text"];
				echo '<a href="'.$deleteCommentURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&c_id='.$row["id"].'"><i class="deleteCommentBtn"></i></a></div>';
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


</body>
</html>