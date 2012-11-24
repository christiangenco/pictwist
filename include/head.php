<?php
  session_start();

  // ### LINKS ###
  // current working directory, relative to the root (AKA: /pictwist/)
  $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
  
  // URL of login script (AKA login.php)
  $login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';

  // URL of login handler script (AKA login.processor.php)
  $loginHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.processor.php';
  
  // URL of search script (AKA search.php)
  $search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';

  // ### ADDITIONAL LINKS ###
  // URL of search handler script (AKA search.php)
  $searchHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.processor.php';

  // URL of user profile page script (AKA profile.php)
  $profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';

  // URL of view script (AKA view.php)
  $view = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'view.php';

  // URL of photo edit script (AKA edit.php)
  $edit = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'edit.photo.php';

  // URL of photo edit handler script (AKA edit.php)
  $editHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'edit.photo.processor.php';
  
  // URL of upload script (AKA upload.php)
  $upload = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'upload.php';

  // URL of upload handler script (AKA upload.php)
  $uploadHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php';

  // URL of tag script (AKA upload.php)
  $tag = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'tag.php';

  // URL of tag handler script (AKA upload.php)
  $tagHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'tag.processor.php';

  // URL of logout script (AKA killSession.php)
  $killSession = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'killSession.php';

  // ### PERMISSION CONTROL ###
  function isLoggedIn(){
    if(isset($_SESSION['uid'])) 
      { return true; }
    else 
      { return false; }
  }

  function getCurrentUser(){
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
              <div id="userName"><? echo $currentUser['username'] ?></div>
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