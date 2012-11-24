<?php
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
  
  // URL of edit script
  $editURL = $baseURL . 'edit.php';

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
    return true;
  }

  function getCurrentUser(){
    // TODO: make this actually get the current user
    $currentUser = array("username" => "test_username", "id" => -1, "name" => "Test Username");
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

      <a href="#">
        <img id="logotext" src="img/logotext.png" />
        <img id="logoswirl" src="img/swirl.png" />
      </a>

      <div id="header_right">

        <div id="userBadgeContainer">

          <!-- only one of these will actually be shown -->
          <div id="notSignedIn">
            <a href="#">Sign in</a> or <a href="#">Join PicTwist</a>
          </div>

          <div id="userBadge">
            <img id="userPic" src="img/default_pic.png" />
            <div id="userInfo">
              <div id="userName">Username1234</div>
              <div id="userLinks"><a href="#">My Albums</a> | <a href="#">Sign out</a></div>
            </div>
          </div>

        </div>          
      </div>

      <div id="searchContainer">
        <div class="m-input-append">
          <input class="m-wrap m-ctrl-large" type="text" placeholder="Search for photos">
          <a class="m-btn icn-only blue"><i class="icon-search icon-white"></i></a>
          <a id="advSearchToggle" href="#" class="m-btn blue icn-only"><i class="icon-chevron-down icon-white"></i></a>
        </div>
        <div id="advSearch">
          <p>Advanced option 1</p>
          <p>Advanced option 2</p>
          <p>Advanced option 3</p>
        </div>
      </div>
    </div>    

    <div id="content">