<?php
	session_start();
?>
<?php
  ob_start();
  session_start();

  // ### LINKS ###
  // current working directory, relative to the root (AKA: /pictwist/)
  $relativeDirectory = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
  $baseURL = "http://" . $_SERVER['HTTP_HOST'] . $relativeDirectory;
  
  // URL of login handler script
  $loginHandlerURL = $baseURL . 'login.processor.php';
  
  // URL of login script (AKA login.php)
  $loginURL = $baseURL . 'login.php';
  
  // URL of logout script
  $logoutURL = $baseURL . 'logout.php';
  
  // URL of search script
  $searchURL = $baseURL . 'search.php';
  
  // URL of error script
  $errorURL = $baseURL . 'error.php';
  
  // URL of view script
  $viewURL = $baseURL . 'view.php';

  // URL of view processor (add comments/ individual tags) script
  $viewHandlerURL = $baseURL . 'view.processor.php';
  
  // URL of edit script
  $editURL = $baseURL . 'edit.php';

  // ### ADDITIONAL LINKS ###
  // URL of search handler script 
  $searchHandlerURL = $baseURL . 'search.processor.php';

  // URL of user profile page script
  $profileURL = $baseURL . 'profile.php';

  // URL of photo edit handler script
  $editHandlerURL = $baseURL . 'edit.processor.php';
  
  // URL of upload script 
  $uploadURL = $baseURL . 'upload.php';

  // URL of upload handler script 
  $uploadHandlerURL = $baseURL . 'upload.processor.php';

  // URL of upload script 
  $uploadSuccessURL = $baseURL . 'upload.success.php';

  // URL of tag script 
  $tagURL = $baseURL . 'tag.php';

  // URL of tag handler script 
  $tagHandlerURL = $baseURL . 'tag.processor.php';

  // URL of registration script 
  $registerURL = $baseURL . 'register.php';

  // URL of registration handler script 
  $registerHandlerURL = $baseURL . 'register.processor.php';

  // URL of favorite handler script
  $favoriteHandlerURL = $baseURL . 'favorite.processor.php';

  // URL of deletion handler script
  $deleteHandlerURL = $baseURL . 'delete.processor.php';

  // ### DATABASE ###

  // usage: call connectToDb() on every page you need to
  // use the database on
  function connectToDb(){
    $con = mysql_connect("localhost", "pictwist", 'secret');
    if(!$con) die('Could not connect: ' . mysql_error());
    mysql_select_db("pictwist", $con) or die("Unable to select database: " . mysql_error());
  }

  function sql($query){
    $result = mysql_query($query) or die (mysql_error());
    return $result;
  }

  // ### PERMISSION CONTROL ###
  function isLoggedIn(){
    // TODO: make this actually return true if user is logged in
    // false if not
    if(isset($_SESSION['uid']) || ( isset($currentUser['id']) && $currentUser['id'] > 0 )) 
      { return true; }
    else 
      { return false; }
  }

  function redirect_if_not_logged_in(){
    if(!isLoggedIn()){
      $_SESSION['error'] = "You must be logged in to view this page";
      $_SESSION['redirect'] = $loginURL;
      redirect($errorURL);
    }
  }

  function getCurrentUser(){
    // TODO: make this actually get the current user
    if(isset($_SESSION['uid'])) { $uid = $_SESSION['uid']; }
    else { $uid = 2; $_SESSION['uid'] = $uid;}

    if(isset($_SESSION['uname'])) { $uname = $_SESSION['uname']; }
    else { $uname = "nsliwa@smu.edu"; $_SESSION['uname'] = $uname;}

    if(isset($_SESSION['mname'])) { $mname = $_SESSION['mname']; }
    else { $mname = "Nicole Sliwa"; $_SESSION['mname'] = $mname;}

    $currentUser = array("username" => $uname, "id" => $uid, "name" => $mname);
    
    return $currentUser;
  }

  $currentUser = getCurrentUser();

  function logout(){
    // TODO: make this actually log you out
    redirect('logoutURL.php');
  }

  // usage: redirect("http://google.com")
  function redirect($url){
    header("HTTP/1.1 307 Temporary Redirect");
    header("Location: $url");
  }

  // usage: params("username")
  // escapes the strings so you can insert things returned by
  // this method directly into the database
  function params($key){
    return $_REQUEST[$key] ? mysql_real_escape_string(stripslashes($_REQUEST[$key])) : null;
  }

  // if the user is on a page (s)he shouldn't be on,
  // redirect them to the homepage and tell them they shouldn't be here.

?>

<!DOCTYPE html>
<head>
<title>PicTwist</title>
  <link href="styles/styles.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
  <script src="js/jquery-ui-1.9.2.custom.min.js"></script> 
  <script type="text/javascript" src="js/script.js"></script>
  <link href="metro/css/m-styles.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="img/icon.ico" />

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
	<link href="styles/viewPhotoStyles.css" rel="stylesheet" type="text/css">
</head>

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
</html>