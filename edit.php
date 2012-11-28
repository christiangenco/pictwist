<?php INCLUDE 'include/head.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to edit photos!");

    connectToDb();
    $upload = FALSE;

    if(isNotNull($_REQUEST['photo_path']) && isNotNull($_REQUEST['album_id']))
    {
        $album_id = params('album_id');
        $pathname = params('photo_path');
        //unset ($_REQUEST['album_id']);
        //unset ($_REQUEST['photo_path']);

        if(isset($_SESSION['parent']))
        {
            $query = "insert into photos(path, parent_photo_id, album_id) values('" . $pathname . "', " . $_SESSION['parent'] . ", " . $album_id . ");";
            unset($_SESSION['parent']);
        }
        else
        {
            $query = "insert into photos(path, album_id) values('" . $pathname . "', " . $album_id . ");";
        }
        $result = sql($query);
        if(!$result)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            unlink($pathname);
            redirect($errorURL);
        }
        else
        {
            $query = "select id from photos where path = '".$pathname."';";
            $result_id = sql($query);
            if($row = mysql_fetch_array($result_id))
            {
                $photo_id = $row[id];
            }
            $_SESSION['photo_id'] = $photo_id;
            $upload = TRUE;
        }
        //"select title, path from photos where id='$pid';";
    }
    else if(isNotNull($_REQUEST['p_id']))
    {
        $photo_id = params('p_id');
        $_SESSION['photo_id'] = $photo_id;
    }
    else if(isNotNull($_SESSION['photo_id']))
    {
        $photo_id = params('photo_id');
    }
    if(!isNotNull($photo_id))
    {
        errorRedirect($upload, 'Error! Your photo could not be uploaded. Please try again.', $uploadURL);
        errorRedirect(!$upload, 'Error! You need to select a photo to edit.', $profileURL);
    }
    else
    {
        // ######## add to views.php!!!!
        //echo "owner: " . isOwner($photo_id);
        //header("Location: $loginURL");
        errorRedirect(!isOwner($photo_id), "Error! You do not have permission to edit this photo!", $viewURL);
        $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
        $result = sql($query);
        $query = "select title, description, path, private, album_id from photos where id = ".$photo_id.";";
        $result_photo = sql($query);
        errorRedirect(!$result_photo, "Error! No photo selected for editing.", $profileURL);
        while($row = mysql_fetch_array($result_photo))
        {
            $photo_title = $row[title];
            $pathname = $row[path];
            $private = $row['private'];
            $album_id = $row[album_id];
            $description = $row[description];;
        }
        $query = "select id, type, text from tags where photo_id = ".$photo_id.";";
        $result_tags = sql($query);
    }
    
    
?>

<p>Your photo: <?php echo $photo_id;?></p>
<form id="Insert" action="<?php echo $editHandlerURL ?>" enctype="multipart/form-data" method="post"> 
    <div class="pic" ><!--style="float:top; float:left; padding:50px;"-->
        <img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>" width=400 height=400/>
        <p>
            Album: <?php echo $album_id ?> <br/>
            Title: <input type="text" name="title" value=<?php echo $photo_title;?>><br/>
            Description: <br/>
            <input type="textarea" name="description" value=<?php echo $description;?>>
        </p>
    </div>
    <div id="tagsFields">
        Tags: <br/>
        <table>
            <?php
                while($row = mysql_fetch_array($result_tags))
                {
                    echo '<tr>'
                        .'<td>'.$row[type].': </td>'
                        .'<td>'.$row[text].'</td>'
                        .'</tr>';
                }
            ?>
        </table>
    </div>
    <p>
        <input type="button" value="Add Another Tag" onclick="addTagField();">
    <p> 
        <input type="submit" name="submit" value="Complete" onclick="alert('submitting to processor);"> 
    </p> 
 
</form> 

<script>
    function addTagField()
    {
        var newdiv = document.createElement('div');
          newdiv.innerHTML = "<select name='tag[]'>"
            +"<option value='location'>Location</option>"
            +"<option value='camera type'>Camera Type</option>"
            +"<option value='color'>Color</option>"
            +"<option value='keyword'>Keyword</option>"
            +"<option value='person'>Person</option>"
            +"</select>" 
            +"<input type='text' name='tagContent[]' placeholder='tag'><br/>";
          document.getElementById('tagsFields').appendChild(newdiv);
    }
</script>
<?php INCLUDE 'include/foot.php' ?>