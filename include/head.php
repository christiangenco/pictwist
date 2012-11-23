<?php
  // ### LINKS ###
  // current working directory, relative to the root (AKA: /pictwist/)
  $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
  
  // URL of login handler script (AKA login.processor.php)
  $loginHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.processor.php';
  
  // URL of login script (AKA login.php)
  $login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
  
  // URL of search script (AKA profile.processor.php)
  $search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';

  // ### PERMISSION CONTROL ###
  function isLoggedIn(){
    return true;
  }

  function getCurrentUser(){
    $currentUser = array("username" => "test_username", "id" => -1, "name" => "Test Username");
    return $currentUser;
  }
  $currentUser = getCurrentUser();

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