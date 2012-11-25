<?php INCLUDE 'include/head.php';?>

<?php

	if(isset($_SESSION['error']))
    {
        echo '<p>'.$_SESSION['error'].'</p>';
        echo '<p>You will now be logged out.</p>';
    }
    session_destroy();

    header("Refresh: 1; URL='$loginURL'");
?>

<?php INCLUDE 'include/foot.php' ?>