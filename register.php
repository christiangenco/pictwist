<<<<<<< HEAD
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
=======
<?php INCLUDE 'include/head.php'; ?>

		<div class="centerBox">
			<h1>
				Create a PicTwist Account
			</h1>
			<div class="formContainer">
			
			
				<form id="register" action="register.processor.php" method="post">
				
					
					
						<div class="m-input-prepend">
							<span class="add-on"><label for="name">Name *</label></span>
							<input class="m-wrap" id="name" type="text" name="name">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="email">E-mail *</label></span>
							<input class="m-wrap" id="email" type="text" name="email">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="password_hash">Password *</label></span>
							<input class="m-wrap" id="password_hash" type="password" name="password_hash" onkeyup="checkPasswordMatch()">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="password_hash2">Repeat password *</label></span>
							<input class="m-wrap" id="password_hash2" type="password" name="password_hash2" onkeyup="checkPasswordMatch()">
						</div>
						<div id="passwordMatchIcon" class="passwordMatchIcon"></div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="city">City</label></span>
							<input class="m-wrap" id="city" type="text" name="city">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="state">State</label></span>
							<input class="m-wrap" id="state" type="text" name="state">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="country">Country</label></span>
							<input class="m-wrap" id="country" type="text" name="country">
						</div>
						<div class="m-input-prepend">
							<span class="add-on"><label for="bio">About Me</label></span>
							<textarea class="m-wrap" id="editBio" type="text" name="bio"></textarea>
						</div>										
					
						<div id="registerValidation"></div>
						<input id="submitRegister" class="m-btn blue thinShadow" type="submit" name="submit" value="Sign Up">
				</form>
				
			</div>	
			
			<div class="boxDivider"></div>
			
			<form method="post" action="login.php">
				<h3>Already a member?</h3>
				<input class="m-btn blue thinShadow" type="submit" value="Log In">
			</form>
			
		</div><!-- end of centerBox -->
		

>>>>>>> Some styling done
<?php INCLUDE 'include/foot.php' ?>