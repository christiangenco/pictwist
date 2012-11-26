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
    if(isset($_SESSION['uid'])) 
      { return true; }
    else 
      { return false; }
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
    redirect('index.php');
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
  <script type="text/javascript" src="js/script.js"></script>
  <link href="metro/css/m-styles.min.css" rel="stylesheet"> 

</head>
<body>

  <div id="pageContainer">  
  
    <div id="header">

      <a href="<? echo $baseURL ?>">
        <img id="logotext" src="img/logotext.png" />
        <img id="logoswirl" src="img/swirl.png" />
      </a>

      <div id="header_right">

        <div id="userBadgeContainer">

          <!-- only one of these will actually be shown -->
          <div id="notSignedIn">
            <a href=<?php echo $loginURL;?>>Sign in</a> or <a href=<?php echo $registerURL;?>>Join PicTwist</a>
          </div>

          <div id="userBadge">
            <img id="userPic" src="img/default_pic.png" />
            <div id="userInfo">
              <div id="userName"><?echo $currentUser['username'];?></div>
              <div id="userLinks"><a href=<?php echo $profileURL;?>>My Albums</a> | <a href=<?php echo $logoutURL;?>>Sign out</a></div>
            </div>
          </div>

        </div>          
      </div>

      <div id="searchContainer">
        <div class="m-input-append">
          <form method="get" action=<?php echo $searchURL;?>>
            <input class="m-wrap m-ctrl-large" name="query" type="text" placeholder="Search for photos" value="<? echo $_REQUEST['query'] ?>">
            <a class="m-btn icn-only blue" href="#"><i class="icon-search icon-white"></i></a>
            <a id="advSearchToggle" href="#" class="m-btn blue icn-only"><i class="icon-chevron-down icon-white"></i></a>
          </form>
        </div>
        <div id="advSearch">
          <p>Advanced option 1</p>
          <p>Advanced option 2</p>
          <p>Advanced option 3</p>
        </div>
      </div>
    </div>    

    <div id="content">
