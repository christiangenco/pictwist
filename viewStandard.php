<?php INCLUDE_ONCE 'include/head.php' ?>

<?php
	connectToDb();
   	if(isNotNull($_REQUEST['p_id']))
    {
        $photo_id = params('p_id');
        $_SESSION['photo_id'] = $photo_id;
    }
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    
    errorRedirect(!isset($photo_id), 'Error! You need to select a photo to edit.', $errorURL);

    // ######## add to views.php!!!!
    $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
    $result = sql($query);
    $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
    $result_photo = sql($query);
    while($row = mysql_fetch_array($result_photo))
    {
        $photo_title = $row[title];
        $pathname = $row[path];
        $private = $row['private'];
        $album_id = $row[album_id];
        $description = $row[description];;
    }
    $query = "select id, type, text from tags where photo_id = '".$photo_id."';";
    $result_tags = sql($query);
    $query = "select text, c.updated_at, u.name from photos p JOIN comments c JOIN users u where p.id = ".$photo_id." AND p.id = c.photo_id AND u.id = c.user_id order by c.updated_at desc;";
	//echo $query . '<br/><br/>';
	$result_comments = sql($query);
 
    
    
?>
<p>
	<?php
	echo '<a id="' . $photo_id . '" href="'.$editURL.'?p_id=' . $photo_id . '">'.
		'Edit Photo</a><br/>';
	echo '<a id="' . $photo_id . '" href="'.$favoriteHandlerURL.'?p_id=' . $photo_id . '">'.
		'Favorite Photo</a><br/>';
    echo '<a id="' . $photo_id . '" href="'.$twistURL.'?p_id=' . $photo_id . '">'.
        'Twist!</a><br/>';
    echo '<a id="' . $photo_id . '" href="'.$twistHistoryURL.'?p_id=' . $photo_id . '">'.
        'View Twist History</a><br/>';
	echo '<a id="' . $photo_id . '" href="'.$deleteHandlerURL.'?p_id=' . $photo_id . '">'.
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
	                        .'<td>'.$row[type].': </td>'
	                        .'<td>'.$row[text].'</td>'
	                        .'</tr>';
	                }
	            ?>
	        </table>
	        <form id="Insert" action="<?php echo $viewHandlerURL ?>" enctype="multipart/form-data" method="post">
	        <select name='tag'>
	            <option value='location'>Location</option>
	            <option value='camera type'>Camera Type</option>
	            <option value='color'>Color</option>
	            <option value='keyword'>Keyword</option>
	            <option value='person'>Person</option>
	        </select>
	        <input type='text' class="newTag" name='tagContent' rows="1" cols="10" placeholder=' Add Tag'><br/>
	        <input type='submit' class="submitTag" name='submit' value='+'>
	        <?php
	        	echo '<a id="' . $photo_id . '" id="favoriteButton" class="control" href="'.$favoriteHandlerURL.'?p_id=' . $photo_id . '">'.
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
					$row[name] . ' said ' . $row[text] . ' on '. $row[updated_at] .
					'</div>';
			}
		?>
	</div>
	<div class="newComment">
		<?php
		if($currentUser['id'] > 0)
		{
			echo '<form method="post" action="' . $viewHandlerURL . '">'.
				'<input class="commentText" type="textarea" name="comment" rows="3" cols="33" placeholder="comment here..."><br/>'.
				'<input class="submitComment" type="submit" name="submit" value="Submit Comment">'.
				'</form>';
		}
		?>
	</div>
 
</form> 

<?php INCLUDE_ONCE 'include/foot.php' ?>