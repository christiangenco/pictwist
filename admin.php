<?php INCLUDE 'include/head.php'; ?>
<?php 
	connectToDb();
	redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to view this page!");
    errorRedirect(!isAdmin(), "Error! You do not have permission to view this this!", $indexURL);

    $query="SELECT * FROM flagged ORDER BY content_type DESC, priority DESC;";
    //echo $query . "<br/>";
    $result = sql($query);
?>

<script type="text/javascript">
	setTitle("Admin Control Panel");
</script>

<a class="returnLink" href="<?php echo $profileURL;?>">< Back to my profile</a>

	<div class="fLeft box">
	
		<h1>
			Administrator Actions
		</h1>
		
		<div class="formContainer">
			
			<form id="adminPage" action="admin.processor.php" method="post">			
							
					<h4>Promote user to administrator...</h4>
					<div class="m-input-prepend">
						<span class="add-on"><label for="setAdminID">By ID #: </label></span>
						<input class="m-wrap" id="setAdminID" type="text" name="setAdminID" placeholder="ID #">
					</div>
									
					<div class="m-input-prepend">

						<span class="add-on"><label for="setAdminUserName">By User's Name: </label></span>
						<input class="m-wrap" id="setAdminUserName" type="text" name="setAdminUserName" placeholder="User Name">

					</div>
									
					<div class="m-input-prepend">
						<span class="add-on"><label for="setAdminUserEmail">By E-mail: </label></span>
						<input class="m-wrap" id="setAdminUserEmail" type="text" name="setAdminUserEmail" placeholder="E-mail">
					</div>
						
					<div class="boxDivider"></div>
									
					<div class="m-input-prepend">
						<span class="add-on"><label for="viewUserInfo">View User's Information: </label></span>
						<input class="m-wrap" id="viewUserInfo" type="text" name="viewUserInfo" placeholder="E-mail">
					</div>
						
					<div class="boxDivider"></div>					
					
					<div class="m-input-prepend">
						<span class="add-on"><label for="suspendUser">Suspend User: </label></span>
						<input class="m-wrap" id="suspendUser" type="text" name="suspendUser" placeholder="E-mail">
					</div>
									
					<div class="m-input-prepend">
						<span class="add-on"><label for="unsuspendUser">Unsuspend User: </label></span>
						<input class="m-wrap" id="unsuspendUser" type="text" name="unsuspendUser" placeholder="E-mail">
					</div>
									
					<div class="m-input-prepend">
						<span class="add-on"><label for="deleteUser">Delete User: </label></span>
						<input class="m-wrap" id="deleteUser" type="text" name="deleteUser" placeholder="E-mail">
					</div>
						
					<div class="boxDivider"></div>
									
					<input class="m-btn thinBorder" type="submit" name="submit" value="Submit">
					
			</form>
			
		</div>
		
	</div>
	
	<div class="fRight box adminFlags">

		<h1 class="centerAlign">
			Flagged Content
		</h1>
		<?php
			while($row2 = mysql_fetch_array($result))
			{
				$query = "SELECT * from ".$row2['content_type']." WHERE id=".$row2['content_id'].";";
				//echo $query . "<br/>";
				$result_content = sql($query);
				if($row2['content_type'] == "comments")
				{
					$query = "SELECT c.id, c.text, c.photo_id, p.album_id from comments c JOIN photos p WHERE c.id=".$row2['content_id']." AND c.photo_id=p.id;";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo "<p>"
						."<form action='".$sensorshipURL."' method='post'>"
						."<a href='".$flagClearURL."?fl_id=".$row2['id']."'>X </a>"
						."<input type='text' value='".$row['text']."' name='comment'>"
						."<input type='hidden' value='".$row['id']."' name='id'>"
						."<input type='submit' value='sensor' name='submit'>"

						." on photo <a href='".$viewURL."?p_id=".$row['photo_id']."&a_id=".$row['album_id']."'>".$row['photo_id']."</a></p>";
					}
				}

				if($row2["content_type"] == "photos")
				{
					$query = "SELECT * from photos p WHERE p.id=".$row2['content_id'].";";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo '<p><a href="'.$flagClearURL.'?fl_id='.$row2['id'].'">X </a>Photo: <a id="' . $row["id"] . '"" href="'.$viewURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
						'<img src="'.$row["path"].'" height=100 width=100 alt="'.$row["title"].'"></a></p>';
					}
				}

				if($row2["content_type"] == "users")
				{
					$query = "SELECT * from users u WHERE u.id=".$row2['content_id'].";";
					//echo $query . "<br/>";
					$result_content = sql($query);
					if($row = mysql_fetch_array($result_content))
					{
						echo "<p><a href='".$flagClearURL."?fl_id=".$row2['id']."'>X </a>User: <a href='".$profileURL."?u_id=".$row['id']."'>".$row['name']."</a></p>";
					}
				}

				if($row2["content_type"] == "tags")
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
		
	</div>

<?php INCLUDE 'include/foot.php'; ?>

<script type="text/javascript">
	$("#footer").hide();
</script>

