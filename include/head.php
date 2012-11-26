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
</head>
<body>
	
	<div id="pageContainer">	
		
		<div id="header_bg"></div>
		<div id="header">
		
			<a href="<? echo $baseURL ?>">
				<img id="logotext" src="img/logotext.png" />
				<img id="logoswirl" src="img/swirl.png" />
			</a>
			
			<div id="header_right">
			
				<div id="userBadgeContainer" class="thinShadow">
				
					<!-- only one of these will actually be shown -->
					<? if ($currentUser['id'] == -1): ?>
						<div id="notSignedIn">
							<a id="gotoSignIn" href="#" class="m-btn blue thinShadow">Sign In</a><a  id="gotoRegister" href="<?php echo $registerURL;?>" class="m-btn blue thinShadow">Join PicTwist</a>
						</div>
					
					
					<div id="signInFormContainer">
						<form id="signInForm" method="get" action="<?php echo $loginHandlerURL ?>">
							<input id="usernameField" class="m-wrap" type="text" type="text" name="email" placeholder="Email" />
							<input id="passwordField" class="m-wrap" type="password" name="pwd" placeholder="Password" />
							<a id="signInBtn" class="m-btn icn-only blue thinShadow">Sign In</a>
						</form>
			
						<i id="closeBtn"></i>
					</div>
					
					
					<? else: ?>
						<div id="userBadge">
							<img id="userPic" src="img/default_pic.png" />
							<div id="userInfo">
								<div id="userName"><?echo $currentUser['username'];?></div>
								<div id="userLinks"><a href="<?php echo $profileURL;?>">My Albums</a> | <a href="<?php echo $logoutURL;?>">Sign out</a></div>
							</div>
						</div>
						
					<? endif; ?>
					
				</div>							
			
				<div id="searchContainer">
					<form id="searchForm" action="<?php echo $searchURL;?>">
  					<input id="searchField" class="m-wrap" type="text" placeholder="Search for photos" value="<? echo $_REQUEST['query'] ?>"/>
  					<a id="searchBtn" class="m-btn icn-only blue thinShadow"><i class="icon-search icon-white"></i></a>
          </form>
				</div>					
				
			</div>
		</div>		
		
		
		
		<div id="content">
