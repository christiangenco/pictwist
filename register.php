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
		
<?php INCLUDE 'include/foot.php' ?>