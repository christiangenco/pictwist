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

  $updateProfilePictureHandlerURL = $baseURL . 'update_profile_picture.processor.php';

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

   // URL of tag deletion handler script
  $deleteTagURL = $baseURL . 'delete.tag.php';

   // URL of comment deletion handler script
  $deleteCommentURL = $baseURL . 'delete.comment.php';

  // URL of deletion handler script
  $editInfoURL = $baseURL . 'editInfo.php';
  
  // URL of deletion handler script
  $editInfoHandlerURL = $baseURL . 'editInfo.processor.php';

  //URL of album editor script
  $albumEditURL = $baseURL . 'album.editor.php';

  $albumsURL = $baseURL . 'albums.php';

  $albumURL = $baseURL . 'album.photos.php';

  // URL of admin script
  $adminURL = $baseURL . 'admin.php';

  // URL of index script
  $indexURL = $baseURL . 'index.php';

  // URL of admin script
  $adminHandlerURL = $baseURL . 'admin.processor.php';

  // URL of flagging script
  $flagContentURL = $baseURL . 'flag.processor.php';

  //URL of flag clearing script
  $flagClearURL = $baseURL . 'flag.clear.php';

  // URL of deleteAccount script
  $deleteAccountURL = $baseURL . 'deleteAccount.php';

  // URL of deleteAccount handler script
  $deleteAccountHandlerURL = $baseURL . 'deleteAccount.processor.php';

  // URL of subscribing script
  $subscriptionHandlerURL = $baseURL . 'subscribe.processor.php';

  // URL of favorite photo script
  $favoriteDisplayURL = $baseURL . 'favorite.display.php';

  // URL of sensor comment script
  $sensorshipURL = $baseURL . 'comment.sensor.php';
  
  // ### DATABASE ###
  $currentUser = getCurrentUser();

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
    if(isset($currentUser['id']) && $currentUser['id'] > 0 ) 
      { return TRUE; }
    else 
      { return FALSE; }
  }

  function redirect_if_not_logged_in($redirectURL, $msg="You must be logged in to view this page", $parent=""){
    global $errorURL;
    if(!isLoggedIn()){
      $_SESSION['error'] = $msg;
      $_SESSION['redirect'] = $redirectURL;
      redirect($errorURL);
    }
  }

  function getCurrentUser(){
    connectToDb();
    
    // TODO: make this actually get the current user
    if(isset($_SESSION['uid'])) { 
      $uid = $_SESSION['uid'];
      $user_data = mysql_fetch_array(sql("SELECT * FROM users WHERE id=".escape($uid)));

      $email = $user_data["email"];
      $name = $user_data["name"];
      $admin = $user_data["admin"]==0;
      $profile_picture_path = $user_data["profile_picture_path"];
    }
    else { 
      $uid = -1;
      $email = "Visitor";
      $name = "Unknown";
      $admin = FALSE;
      $profile_picture_path = "img/default_pic.png";
    }
    $_SESSION['uid'] = $uid;
    $_SESSION['email'] = $email;
    $_SESSION['admin'] = $admin;
    $_SESSION['profile_picture_path'] = $profile_picture_path;

    $currentUser = array("username" => $email, "id" => $uid, "name" => $name, "admin" => $admin, "profile_picture_path" => $profile_picture_path);
    
    return $currentUser;
  }

  function isUser($email){
    $query = "Select id, email FROM users WHERE email = '".$email."';";
    //echo $query . "<br/><br/>";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
      if($email = $row['email'])
      {
        return TRUE;
      }
      return FALSE;
    }
    return FALSE;
  }

  function isContainingAlbum($photo_id, $album_id)
  {
    $query = "Select id, album_id FROM photos WHERE id = ".$photo_id." AND album_id = ". $album_id .";";
    //echo $query . "<br/><br/>";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
      if($photo_id = $row['id'] && $album_id = $row['album_id'])
      {
        return TRUE;
      }
      return FALSE;
    }
    return FALSE;
  }

  function isRestrictedPhoto($photo_id, $album_id)
  {
    //echo $photo_id . " " . $album_id . "<br/>";
    
    if(!isContainingAlbum($photo_id, $album_id))
      {return TRUE;}
    
    if(!isPrivateAlbum($album_id) && !isPrivatePhoto($photo_id))
      {return FALSE;}
    if(!isLoggedIn())
      {return TRUE;}
    if(isOwner($photo_id))
      {return FALSE;}
    if(isAdmin())
      {return FALSE;}
    if(isShared($photo_id))
      {return FALSE;}
      
    return FALSE;
  }

  function isPrivateAlbum($album_id)
  {
    $query = "SELECT private from albums WHERE id = ".$album_id.";";
    $result = sql($query);
    if($row = mysql_fetch_array($result))
    {
      return $row['private'];
    }
    else return FALSE;
  }

  function isShared($album_id)
  {
    if(!isLoggedIn())
      {return false;}
    $currentUser = getCurrentUser();
    $query = "SELECT user_id, album_id FROM shared WHERE user_id = ".$currentUser['id']." AND album_id = ".$album_id.";";
    $result = sql($query);
    if(!$result)
      {return FALSE;}
    return TRUE;
  }

  function isFavorite($photo_id)
  {	
    global $currentUser;
    $query = "SELECT photo_id, user_id FROM favorites WHERE photo_id = ".$photo_id." AND user_id = ".$currentUser['id'].";";
    //echo $query . "<br/>";
    $result = sql($query);
    if(mysql_num_rows($result) === 0)
    {
      return FALSE;
    }
    else
    {
      return TRUE;
    }
  }

  function isPrivatePhoto($photo_id)
  {
    $query = "SELECT private from photos WHERE id = ".$photo_id.";";
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
    //echo "query: " . $query . "<br/>";
    $result = sql($query);
    //echo "result: " . $result;
    if($row = mysql_fetch_array($result))
    {
      //echo "pid: " . $row['id'];
      if($row['id'] === $photo_id)
        {//echo "OWNER=true"; 
      return TRUE;}
      else
        {//echo "OWNER=false1"; 
      return FALSE;}
    }
    //echo "OWNER=false2";
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
    if(isset($currentUser['admin']))
    {
      return $currentUser['admin'];
    }
    else
    {
      global $currentUser;// = getCurrentUser();
      $uid = $currentUser['id'];
      $query = "Select admin FROM users WHERE id = ".$uid.";";
      $result = sql($query);
      if($row = mysql_fetch_array($result))
      {
        return $row['admin'];
      }
      return FALSE;
    }
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
  function redirect($url, $parent=""){
    //echo "redirecting to '$url'";
    header("HTTP/1.1 307 Temporary Redirect");
    header("Location: $url");
  }

  function errorRedirect($condition, $error, $redirect, $parent=""){
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

  //echo print_r($currentUser);  

  // escapes strings to prevent SQL injections
  function escape($string){
    return mysql_real_escape_string(stripslashes($string));
  }

  // usage: params("username")
  // escapes the strings so you can insert things returned by
  // this method directly into the database
  function params($key){
    return $_REQUEST[$key] ? escape($_REQUEST[$key]) : null;
  }

  // if the user is on a page (s)he shouldn't be on,
  // redirect them to the homepage and tell them they shouldn't be here.
?>