<?php INCLUDE 'include/head.php'; ?>
<?php
        $uid = $currentUser['id'];
	//echo "UID: " . $uid;
        connectToDb();
	//require_once "password.php";
	

	if(isset($_POST['submit']))
	{//if the form is submitted DO THIS:
            
            $deleteAccount = mysql_query("DELETE FROM users WHERE id='$uid';");
            session_destroy();
            $_SESSION['error'] = "Your account has be deleted.";
            $_SESSION['redirect'] = $loginURL;
            redirect($errorURL);
	}//ends 'submit' loop
?>
<?php INCLUDE 'include/foot.php' ?>