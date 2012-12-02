<?php INCLUDE 'include/head.php'; ?>
<html>
	<head>
		<title>ADMINISTRATOR</title>
	</head>
	
	<body>
		<form id="adminPage" action="admin.processor.php" method="post">
			<h1>
				Administrator's Page
			</h1>
			
                        <p>
				<label for="setAdminID">Set as administrator ID #: </label>
				<input id="setAdminID" type="text" name="setAdminID">
                                <br>
				<label for="setAdminUserName">Set administrator by user name: </label>
				<input id="setAdminUserName" type="text" name="setAdminUserName">
                                <br>
				<label for="setAdminUserEmail">Set administrator user by email: </label>
				<input id="setAdminUserEmail" type="text" name="setAdminUserEmail">
                                <br>
				<label for="viewUserInfo">View User's Information (enter email): </label>
				<input id="viewUserInfo" type="text" name="viewUserInfo">
				<br>
				<!--<label for="suspendUser">Suspend User (enter email): </label>
				<input id="suspendUser" type="text" name="suspendUser">
                                <br>-->
				<label for="deleteUser">Delete User (enter email): </label>
				<input id="deleteUser" type="text" name="deleteUser">
                                <br>
				<label for="country">Country:</label>
				<input id="country" type="text" name="country">
                                <br>
                                <label for="bio">About Me:</label>
				<input id="bio" type="text" name="bio">
                                <br>
                                <input type="submit" name="submit" value="Enter">
			</p>
		</form>
		<form method="post" action="profile.php">
			<input type="submit" value="Back to Profile">
		</form>
	</body>
</html>

<?php INCLUDE 'include/foot.php' ?>