<?php INCLUDE 'include/head.php'; ?>
<?php
  if(isset($_REQUEST['p_id'])){
    // check that we're logged in
    if(!isset($currentUser['id']) || $currentUser['id'] <= 0){
      $_SESSION['error'] = 'Error! You must be logged in!';
      redirect($logoutURL);
    }else{
      connectToDb();
      $user_id = $currentUser['id'];

      // get the photo's path from the database
      $photo = mysql_fetch_array(sql("SELECT path FROM photos WHERE id=" . params("p_id")));
      print_r($photo);
      $profile_picture_path = $photo["path"];

      // set the photo's path to the user's profile's path
      sql("UPDATE users SET profile_picture_path='$profile_picture_path' WHERE id = $user_id");
      
      redirect($profileURL);
    }
  }
?>
<?php INCLUDE 'include/foot.php' ?>