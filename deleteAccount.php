<?php INCLUDE 'include/head.php'; ?>

<html>
	<head>
		<title>Delete Account!?</title>
	</head>
	
	<body>
		<form id="deleteAccount" action="<?php echo $deleteAccountHandlerURL ?>" enctype="multipart/form-data" method="post">
			<h1>
				Delete Account!
			</h1>
			<p>
				Are you sure you want to delete your account? <input type="submit" name="submit" value="Delete">
			</p>
		</form>

                <form method="post" action="profile.php">
                <br><input type="submit" value="Cancel">
                </form>
	</body>
</html>
<?php INCLUDE 'include/foot.php' ?>