<html>
<head>
	<title>Upload a Photo</title>
</head>
<body>
<h1>Upload a Photo!</h1>
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

<form method="post" action="upload.php" enctype="multipart/form-data">
	File Upload <input type="file" name="photo" id="photo"/> <br/>
	<input type="submit" value="Upload"/>
</form>

<?

	echo "uploading... " . ($_FILES['photo']['name']) . " ";
	//This is the directory where images will be saved
	$target = "img/";
	$target = $target . basename( $_FILES['photo']['name']);
	
	echo "Target: " . $target . " ";
	//This gets all the other information from the form
	//$name=$_POST['nameMember'];
	//$bandMember=$_POST['bandMember'];
	//$pic=($_FILES['photo']['name']);
	//$about=$_POST['aboutMember'];
	//$bands=$_POST['otherBands'];
	
	
	// Connects to your Database
	//mysql_connect("yourhost", "username", "password") or die(mysql_error()) ;
	//mysql_select_db("dbName") or die(mysql_error()) ;
	
	//Writes the information to the database
	//mysql_query("INSERT INTO tableName (nameMember,bandMember,photo,aboutMember,otherBands)
	//VALUES ('$name', '$bandMember', '$pic', '$about', '$bands')") ;
	
	//Writes the photo to the server
	if(move_uploaded_file($_FILES['photo']['tmp_name'], $target))
	{
	
	//Tells you if its all ok
	echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory";
	}
	else {
	
	//Gives and error if its not
	echo "Sorry, there was a problem uploading your file.";
	}	

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
