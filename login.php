<?php INCLUDE 'include/head.php'; ?>

<html>
	<head>
		<title>Login</title>
		<style type="text/css">
			ul{list-style-type:none; margin:0; padding:0; background-color:blue; padding:5px;}
			li{display:inline; color:white; padding:0px 50px 0px 10px;}
			li a{color:white;}
		</style>
	</head>
	
	<body>
		<ul>
			<li><a href="<?php echo $searchURL ?>">Search Photos</a></li>
			<li style="float:right;"><a href="<?php echo $loginURL ?>">Login</a></li>
			<li style="float:left;"><a href="<?php echo $registerURL ?>">Register</a></li>
		</ul>
		<form id="Login" action="<?php echo $loginHandlerURL ?>" enctype="multipart/form-data" method="post">
			<h1>
				Login
			</h1>
			
			<p>
				<label for="email">Username:</label>
				<input id="email" type="text" name="email">
			</p>
			
			<p>
				<label for="pwd">Password:</label>
				<input id="pwd" type="password" name="pwd">
			</p>
			
			<p>
				<input type="submit" name="submit" value="Login">
			</p>
		</form>
	</body>
</html>
<?php INCLUDE 'include/foot.php' ?>