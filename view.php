<?php INCLUDE 'include/headCode.php';?>

<!DOCTYPE html>
<head>
<title>PicTwist</title>
	<?php INCLUDE 'include/cssAndJsIncludes.php';?>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="fancyBox/source/jquery.fancybox.pack.js?v=2.1.3"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="fancyBox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
	<link href="styles/styles.css" rel="stylesheet" type="text/css">

	<link href="styles/viewPhotoStyles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
    connectToDb();
    //$upload = false;
    if(!isset($currentUser['id']) || $currentUser['id'] <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL);
    } 
    /*
    if(isset($_SESSION['photo_path']) && isset($_SESSION['album_id']))
    {
        $album_id = $_SESSION['album_id'];
        $pathname = $_SESSION['photo_path'];
        unset ($_SESSION['album_id']);
        unset ($_SESSION['photo_path']);

        $query = "insert into photos(path, album_id) values('" . $pathname . "', " . $album_id . ");";
        $result = sql($query);
        if(!$result)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            unlink($pathname);
            redirect($errorURL);
        }
        else
        {
            $query = "select id from photos where path = '".$pathname."';";
            $result_id = sql($query);
            while($row = mysql_fetch_array($result_id))
            {
                $photo_id = $row[id];
            }
            $_SESSION['photo_id'] = $photo_id;
            $upload = true;
        }
        //"select title, path from photos where id='$pid';";
    }
    else*/ if(isset($_REQUEST['p_id']))
    {
        $photo_id = $_REQUEST['p_id'];
        $_SESSION['photo_id'] = $photo_id;
    }
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    if(!isset($photo_id))
    {
        if($upload == true)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            redirect($errorURL);
        }
        else
        {
            $_SESSION['error'] = 'Error! You need to select a photo to edit.';
            $_SESSION['redirect'] = $profileURL;
            redirect($errorURL);
        }
    }
    else
    {
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
    }
    
    
?>
<p>
	<?php
	echo '<a id="' . $photo_id . '" href="'.$editURL.'?p_id=' . $photo_id . '">'.
		'Edit Photo</a><br/>';
	echo '<a id="' . $photo_id . '" href="'.$favoriteHandlerURL.'?p_id=' . $photo_id . '">'.
		'Favorite Photo</a><br/>';
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
	        <input type="hidden" name="lightbox" value=true>
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
				'<input type="hidden" name="lightbox" value=true>'.
				'<input class="commentText" type="textarea" name="comment" rows="3" cols="33" placeholder="comment here..."><br/>'.
				'<input class="submitComment" type="submit" name="submit" value="Submit Comment">'.
				'</form>';
		}
		?>
	</div>
 
</form> 

<script>
/*
    function addTagField()
    {
        var newdiv = document.createElement('div');
          newdiv.innerHTML = "<select name='tag[]'>"
            +"<option value='location'>Location</option>"
            +"<option value='camera type'>Camera Type</option>"
            +"<option value='color'>Color</option>"
            +"<option value='keyword'>Keyword</option>"
            +"<option value='person'>Person</option>"
            +"</select>" 
            +"<input type='text' name='tagContent[]' value='tag'><br/>";
          document.getElementById('tagsFields').appendChild(newdiv);
    }
    */
</script>
</body>
</html>