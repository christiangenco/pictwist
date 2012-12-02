<?php INCLUDE 'include/head.php'; ?>

<script type="text/javascript">
	setTitle("Log In");
</script>

	<div class="centerBox">
	
		<form id="Login" action="<?php echo $loginHandlerURL ?>" enctype="multipart/form-data" method="post">
		
		<h1>Log In</h1>
			
			<div class="formContainer">
				<div class="m-input-prepend">
					<span class="add-on"><label for="email">E-mail:</label></span>
					<input class="m-wrap" id="email" type="text" name="email">
				</div>
				<div class="m-input-prepend">
					<span class="add-on"><label for="pwd">Password:</label></span>
					<input class="m-wrap" id="pwd" type="password" name="pwd">
				</div>
				<input class="m-btn blue thinShadow" type="submit" name="submit" value="Log In">
			</div>
		
		</form>
			
		<div class="boxDivider"></div>
		
		<h3>Need an account?</h3> <a class="m-btn blue thinShadow" href="<? echo $registerURL; ?>">Join PicTwist</a>
		
	</div>
			
<?php INCLUDE 'include/foot.php' ?>