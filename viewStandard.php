<?php INCLUDE_ONCE 'include/head.php' ?>

<?php
	connectToDb();
	errorRedirect(isRestrictedPhoto($_REQUEST['p_id'], $_REQUEST['a_id']), "Error! You do not have permission to view this photo.", $profileURL);
   	
    /*
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    */
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), 'Error! You need to select a photo to edit.', $profileURL);
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
<p>
	<?php
	echo '<a id="' . $photo_id . '" href="'.$editURL.'?p_id='.$photo_id.'&a_id='.$album_id . '">'.
		'Edit Photo</a><br/>';
	echo '<a id="' . $photo_id . '" href="'.$favoriteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
		'Favorite Photo</a><br/>';
    echo '<a id="' . $photo_id . '" href="'.$twistURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
        'Twist!</a><br/>';
    echo '<a id="' . $photo_id . '" href="'.$twistHistoryURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
        'View Twist History</a><br/>';
	echo '<a id="' . $photo_id . '" href="'.$deleteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
		'Delete Photo</a><br/>';
	?>
</p> 
    <div class="fancyimage" ><!--style="float:top; float:left; padding:50px;"-->
        <img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>" width=400 height=400/>
    </div>
    <div class="fancycontent">
        <p>
        	Your photo: <?php echo $photo_id;?> <br/>
            Album: <?php echo $album_id ?> <br/>
            Title: <?php echo $photo_title;?><br/>
            Description: <br/>
            <?php echo $description;?>
        </p>

         <div id="tagsFields" class="tags">
	        Tags: <br/>
	        <table>
	            <?php
	                while($row = mysql_fetch_array($result_tags))
	                {
	                    echo '<tr>'
	                    	.'<td><a href='.$deleteTagURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&t_id='.$row['id'].'>X </a></td>'
	                        .'<td>'.$row["type"].': </td>'
	                        .'<td>'.$row["text"].'</td>'
	                        .'</tr>';
	                }
	            ?>
	        </table>
	        <form id="Insert" action="<?php echo $viewHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id ?>" enctype="multipart/form-data" method="post">
	        <select name='tag'>
	            <option value='location'>Location</option>
	            <option value='keyword'>Keyword</option>
	            <option value='person'>Person</option>
	        </select>
	        <input type='text' class="newTag" name='tagContent' rows="1" cols="10" placeholder=' Add Tag'><br/>
	        <input type='submit' class="submitTag" name='submit' value='+'>
	        <?php
	        	echo '<a id="' . $photo_id . '" id="favoriteButton" class="control" href="'.$favoriteHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
					'Favorite</a><br/>';
	        ?>
	    	</form>
	    </div>

    </div>
	<div class="comments" ><!--style="float:left; clear:both; padding:0px 0px 0px 50px;"-->
		<?php
			while($row = mysql_fetch_array($result_comments))
			{
				echo '<div class="comment">'.
					'<a href='.$deleteCommentURL.'?a_id='.$album_id.'&p_id='.$photo_id.'&c_id='.$row["id"].'>X </a>'.$row["name"] . ' said ' . $row["text"] . ' on '. $row["updated_at"] .
					'</div>';
			}
		?>
	</div>
	<div class="newComment">
		<?php
		if($currentUser['id'] > 0)
		{
			echo '<form method="post" action="' . $viewHandlerURL.'?p_id='.$photo_id.'&a_id='.$album_id. '">'.
				'<input class="commentText" type="textarea" name="comment" rows="3" cols="33" placeholder="comment here..."><br/>'.
				'<input class="submitComment" type="submit" name="submit" value="Submit Comment">'.
				'</form>';
		}
		?>
	</div>
 
</form> 

<?php INCLUDE_ONCE 'include/foot.php' ?>