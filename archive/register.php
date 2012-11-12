<html>
<head>
	<title>Register for This App</title>
</head>
<body>
<h1>Create an Account!</h1>
<h2>Enter Your Info Below</h2>
<form method="post" action="register.php">
	First Name: <input type="text" name="fname" /> <br/>
	Last Name: <input type="text" name="lname" /> <br/>
	UserName: <input type="text" name="uname" /> <br/>
	Password: <input type="password" name="pwd" /> <br/>
	<input type="submit" value="Register!" />
</form>
<form method="post" action="index.php">
	Already a member? <input type="submit" value="Signin!"/>
</form>

<?
if(isset($_POST['pwd']) && strlen($_POST['pwd'])<8){
	echo '<script>alert("Your password must be at least 8 characters.");</script>';
	die();
}

$con = mysql_connect("localhost", "nsliwa", 'nikki9one');
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}

mysql_select_db("HW3", $con)
	or die("Unable to select database: " . mysql_error());

	if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['uname']) && isset($_POST['pwd']))
	{
		$fname = mysql_real_escape_string($_POST['fname']);
		$lname = mysql_real_escape_string($_POST['lname']);
		$uname = mysql_real_escape_string($_POST['uname']);
		$pwd = $_POST['pwd'];
		$pwd_s = hash('sha256', $pwd);
		
		$query = "insert into users(uname, fname, lname, pwd) values('$uname', '$fname', '$lname','$pwd_s');";
		$result = mysql_query($query);
		
		if($result == 1)header("Location: index.php");
		else header("Location: error.php");
	}


mysql_close($con);
?>


</body>
</html>
