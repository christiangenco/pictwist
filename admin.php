<?php INCLUDE 'include/head.php'; ?>
<?php 
	connectToDb();
	redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to view this page!");
    errorRedirect(!isAdmin(), "Error! You do not have permission to view this this!", $indexURL);

    $query="SELECT * FROM flagged ORDER BY content_type DESC, priority DESC;";
    //echo $query . "<br/>";
    $result = sql($query);
?>
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
				<label for="suspendUser">Suspend User (enter email): </label>
				<input id="suspendUser" type="text" name="suspendUser">
                                <br>
                <label for="unsuspendUser">Unsuspend User (enter email): </label>
				<input id="unsuspendUser" type="text" name="unsuspendUser">
                                <br>
				<label for="deleteUser">Delete User (enter email): </label>
				<input id="deleteUser" type="text" name="deleteUser">
                                <br>
                <input type="submit" name="submit" value="Enter">
			</p>
		</form>
		<form method="post" action="profile.php">
			<input type="submit" value="Back to Profile">
		</form>

		<h1>
			Flagged Content
		</h1>
		<?php
			while($row2 = mysql_fetch_array($result))
			{
				$query = "SELECT * from ".$row2['content_type']." WHERE id=".$row2['content_id'].";";
				//echo $query . "<br/>";
				$result_content = sql($query);
				if($row2[content_type] == "comments")
				{
					$query = "SELECT c.id, c.text, c.photo_id, p.album_id from comments c JOIN photos p WHERE c.id=".$row2['content_id']." AND c.photo_id=p.id;";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo "<p><a href='".$flagClearURL."?fl_id=".$row2['id']."'>X </a>"
						."<form action='".$sensorshipURL."' method='post'>"
						."<input type='text' value='".$row['text']."' name='comment'>"
						."<input type='hidden' value='".$row['id']."' name='id'>"
						."<input type='submit' value='sensor' name='submit'>"

						." on photo <a href='".$viewURL."?p_id=".$row['photo_id']."&a_id=".$row['album_id']."'>".$row['photo_id']."</a></p>";
					}
				}

				if($row2[content_type] == "photos")
				{
					$query = "SELECT * from photos p WHERE p.id=".$row2['content_id'].";";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo '<p><a href="'.$flagClearURL.'?fl_id='.$row2['id'].'">X </a>Photo: <a id="' . $row[id] . '"" href="'.$viewURL.'?p_id=' . $row[id] . '&a_id=' . $row[album_id] . '">'.
						'<img src="'.$row[path].'" height=100 width=100 alt="'.$row[title].'"></a></p>';
					}
				}

				if($row2[content_type] == "users")
				{
					$query = "SELECT * from users u WHERE u.id=".$row2['content_id'].";";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo "<p><a href='".$flagClearURL."?fl_id=".$row2['id']."'>X </a>User: <a href='".$profileURL."?u_id=".$row['id']."'>".$row['name']."</a></p>";
					}
				}

				if($row2[content_type] == "tags")
				{
					$query = "SELECT * from tags t JOIN photos p WHERE t.id=".$row2['content_id']." AND t.photo_id=p.id;";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo "<p><a href='".$flagClearURL."?fl_id=".$row2['id']."''>X </a>Tag: ".$row['text']." on photo <a href='".$viewURL."?p_id=".$row['photo_id']."&a_id=".$row['album_id']."'>".$row['photo_id']."</a></p>";
					}
				}

			}
		?>

	</body>
</html>

<?php INCLUDE 'include/foot.php' ?>