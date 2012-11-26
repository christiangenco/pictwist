<?php INCLUDE 'include/head.php';?>

<?php

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
    }

	if(isset($_SESSION['error']))
    {
        echo '<p>'.$_SESSION['error'].'</p>';
        echo '<p>You will now be redirected...</p>';
        unset ($_SESSION['error']);
    }

    if(isset($_SESSION['redirect']))
    {
    	$redirect = $_SESSION['redirect'];
    	unset ($_SESSION['redirect']);
   		header("Refresh: 2; URL='".$redirect."'");
    }
    else
    {
    	header("Refresh: 2; URL='".$loginURL."'");	
    }
?>

<?php INCLUDE 'include/foot.php' ?>