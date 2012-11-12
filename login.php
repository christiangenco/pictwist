<?php
	// filename: login.php
	
	// current working directory, relative to the root (AKA: /pictwist/)
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	//echo $directory_self . '<br/>';
	
	// URL of login handler script (AKA login.processor.php)
	$loginHandler = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.processor.php';
	//echo $indexHandler . '<br/>';
	
	// URL of login script (AKA login.php)
	$login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
	//echo $indexHandler . '<br/>';
	
	// URL of search script (AKA profile.processor.php)
	$search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';
	//echo $indexHandler . '<br/>';
?>

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
			<li><a href="<?php echo $search ?>">Search Photos</a></li>
			<li style="float:right;"><a href="<?php echo $login ?>">Login</a></li>
		</ul>
		<form id="Login" action="<?php echo $loginHandler ?>" enctype="multipart/form-data" method="post">
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
				<input type="submit" name="submit" value="LLogin">
			</p>
		</form>
	</body>
</html>