<?php INCLUDE 'include/head.php';?>
<?php
	if(!isset($currentUser['id']) || $currentUser['id'] <= 0)
	{
		$_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL);
	} 
	if(!isset($_SESSION['photo_path']) || !isset($_SESSION['album_id']))
	{
		$_SESSION['error'] = 'Error! You need to select a photo and album to upload.';
        $_SESSION['redirect'] = $uploadURL;
        redirect($errorURL);
	}
    $album_id = $_SESSION['album_id'];
	$pathname = $_SESSION['photo_path'];
    
?>

<p>Your photo:</p>
<form id="Insert" action="<?php echo $editHandlerURL ?>" enctype="multipart/form-data" method="post"> 
    <div class="pic" ><!--style="float:top; float:left; padding:50px;"-->
        <img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>" width=400 height=400/>
        <p>
            Album: <?php echo $album_id ?> <br/>
            Title: <input type="text" name="title" value="new photo"><br/>
            Description: <br/>
            <input type="textarea" name="description" value="describe your photo">
        </p>
    </div>
    <div id="tagsFields">
        Add Tags: <br/>
        Type:
        <select name='tag[]'>
        <option value='location'>Location</option>
        <option value='camera type'>Camera Type</option>
        <option value='color'>Color</option>
        <option value='keyword'>Keyword</option>
        <option value='person'>Person</option>
        </select>
        <br/>
        Tag: <input type='text' name='tagContent[]' value='tag'><br/>
    </div>
    <p>
        <input type="button" value="Add Another Tag" onclick="addTagField();">
    <p> 
        <input type="submit" name="submit" value="Complete"> 
    </p> 
 
</form> 

<script>
    function addTagField()
    {
        var newdiv = document.createElement('div');
          newdiv.innerHTML = "Type:"
            +"<select name='tag[]'>"
            +"<option value='location'>Location</option>"
            +"<option value='camera type'>Camera Type</option>"
            +"<option value='color'>Color</option>"
            +"<option value='keyword'>Keyword</option>"
            +"<option value='person'>Person</option>"
            +"</select>"
            +"<br/>"
            +"Tag: <input type='text' name='tagContent[]' value='tag'><br/>";
          document.getElementById('tagsFields').appendChild(newdiv);
    }
</script>
<?php INCLUDE 'include/foot.php' ?>