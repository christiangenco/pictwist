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
  
  // URL of view in lightbox script
  $viewLightBoxURL = $baseURL . 'view.php';

  // URL of view script
  $viewURL = $baseURL . 'viewStandard.php';

  // URL of view processor (add comments/ individual tags) script
  $viewHandlerURL = $baseURL . 'view.processor.php';
  
  // URL of edit script
  $editURL = $baseURL . 'edit.php';

  // URL of twist script
  $twistURL = $baseURL . 'twist.php';

  // URL of twist history script
  $twistHistoryURL = $baseURL . 'twistHistory.php';

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
    $currentUser = getCurrentUser();
    if(isset($_SESSION['uid']) || ( isset($currentUser['id']) && $currentUser['id'] > 0 )) 
      { return TRUE; }
    else 
      { return FALSE; }
  }

  function redirect_if_not_logged_in($redirectURL, $msg="You must be logged in to view this page"){
    global $errorURL;
    if(!isLoggedIn()){
      $_SESSION['error'] = $msg;
      $_SESSION['redirect'] = $redirectURL;
      redirect($errorURL);
    }
  }

  function getCurrentUser(){
    // TODO: make this actually get the current user
    if(isset($_SESSION['uid'])) { $uid = $_SESSION['uid']; }
    else { $uid = -1; $_SESSION['uid'] = $uid;}

    if(isset($_SESSION['uname'])) { $uname = $_SESSION['uname']; }
    else { $uname = "nsliwa@smu.edu"; $_SESSION['uname'] = $uname;}

    if(isset($_SESSION['mname'])) { $mname = $_SESSION['mname']; }
    else { $mname = "Nicole Sliwa"; $_SESSION['mname'] = $mname;}

    if(isset($_SESSION['admin'])) {$admin = $_SESSION['admin'];}
    else { $admin = FALSE; $_SESSION['admin'] = $admin;}

    $currentUser = array("username" => $uname, "id" => $uid, "name" => $mname, "admin" => $admin);
    
    return $currentUser;
  }
/*
  function isRestrictedPhoto($photo_id, $album_id=containingAlbum($photo_id), $privatePhoto=isPrivatePhoto($photo_id), $privateAlbum=isPrivateAlbum($album_id))
  {
    if(!$privatePhoto)
      {return false;}
    if(!isLoggedIn())
      {return true;}
    if(isOwner($photo_id))
      {return false;}
    if{isAdmin()}
      {return false;}
    if(isShared($photo_id)
      {return false;}
      return true;
  }

  function
  */

  function isShared($album_id)
  {
    if(!isLoggedIn())
      {return false;}
    $currentUser = getCurrentUser();
    $query = "SELECT user_id, album_id FROM Shared WHERE user_id = ".$currentUser['id']." AND album_id = ".$album_id.";";
    $result = sql($query);
    if(!$result)
      {return FALSE;}
    return TRUE;
  }

  function isPrivatePhoto($photo_id)
  {
    $query = "SELECT private from Photos WHERE id = ".$photo_id.";";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
      return $row['private'];
    }
    else return FALSE;
  }
  function isOwner($photo_id)
  {
    $currentUser = getCurrentUser();
    $uid = $currentUser['id'];
    //echo "uid: " . $uid . " current: " . $currentUser['id'];
    $query = "Select p.id FROM users u JOIN albums a JOIN photos p WHERE u.id=a.user_id AND a.id=p.album_id AND u.id=".$uid." AND p.id=".$photo_id.";";
    //echo $query;
    $result = sql($query);
    //echo "result: " . $result;
    if($row = mysql_fetch_array($result))
    {
      echo "pid: " . $row['id'];
      if($row['id'] === $photo_id)
        {return TRUE;}
      else
        {return FALSE;}
    }
    return FALSE;
    /*
    if(!$result)
      {return false;}
    else
      {return true;}
      */
  }

  function isAdmin()
  {
    $currentUser = getCurrentUser();
    $uid = $currentUser['id'];
    $query = "Select admin FROM users WHERE id = ".$uid.";";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
      return $row['admin'];
    }
    return FALSE;
  }

  function logout(){
    // TODO: make this actually log you out
    redirect('logoutURL.php');
  }

  function isNotNull($var){
    if(isset($var) && $var != "")
      {return TRUE;}
    else 
      {return FALSE;}
  }
  
  // usage: redirect("http://google.com")
  function redirect($url){
    echo "redirecting to '$url'";
    header("HTTP/1.1 307 Temporary Redirect");
    header("Location: $url");
  }

  function errorRedirect($condition, $error, $redirect){
    global $errorURL;
    //echo "start<br/>";
    if($condition == TRUE)
    {
      //echo "!!!!true!!!!";
      $_SESSION['error'] = $error;
      $_SESSION['redirect'] = $redirect;
      //header("Location: ". $redirect);
      redirect($errorURL);
    }
    else
      {//echo "!!!!false!!!!";

      }
    /*
    if($condition)
    {
      $_SESSION['error'] = $error;
      $_SESSION['redirect'] = $redirect;
      redirect($errorURL);
    }
    */
  }

  $currentUser = getCurrentUser();
  //echo print_r($currentUser);  

  // usage: params("username")
  // escapes the strings so you can insert things returned by
  // this method directly into the database
  function params($key){
    return $_REQUEST[$key] ? mysql_real_escape_string(stripslashes($_REQUEST[$key])) : null;
  }

  // if the user is on a page (s)he shouldn't be on,
  // redirect them to the homepage and tell them they shouldn't be here.

?>