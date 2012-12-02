<?php INCLUDE 'include/head.php'; ?>

<html>
	<head>
		<title>REGISTER</title>
	</head>
	
	<body>
		<form id="register" action="register.processor.php" method="post">
			<h1>
				Register
			</h1>
			
                        <p>
				<label for="name">Name*:</label>
				<input id="name" type="text" name="name">
                                <br>
				<label for="email">E-mail*:</label>
				<input id="email" type="text" name="email">
                                <br>
				<label for="password_hash">Password*:</label>
				<input id="password_hash" type="password" name="password_hash">
                                <br>
				<label for="password_hash">Password*:</label>
				<input id="password_hash" type="password" name="password_hash2">
				<br>
				<label for="city">City:</label>
				<input id="city" type="text" name="city">
                                <br>
				<label for="state">State:</label>
				<input id="state" type="text" name="state">
                                <br>
				<label for="country">Country:</label>
				<input id="country" type="text" name="country">
                                <br>
                                <label for="bio">About Me:</label>
				<input id="bio" type="text" name="bio">
                                <br>
                                <input type="submit" name="submit" value="Sign Up">
			</p>
		</form>
		<form method="post" action="login.php">
			<input type="submit" value="Cancel">
		</form>
		<form method="post" action="login.php">
			Already a member? <input type="submit" value="Log In">
		</form>
	</body>
</html>
<?php INCLUDE 'include/foot.php' ?>