<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    $upload = false;
    if(!isset($currentUser['id']) || $currentUser['id'] <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL);
    } 
    if(isset($_SESSION['photo_path']) && isset($_SESSION['album_id']))
    {
        $album_id = $_SESSION['album_id'];
        $pathname = $_SESSION['photo_path'];
        unset ($_SESSION['album_id']);
        unset ($_SESSION['photo_path']);

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
            while($row = mysql_fetch_array($result_id))
            {
                $photo_id = $row[id];
            }
            $_SESSION['photo_id'] = $photo_id;
            $upload = true;
        }
        //"select title, path from photos where id='$pid';";
    }
    else if(isset($_REQUEST['p_id']))
    {
        $photo_id = $_REQUEST['p_id'];
        $_SESSION['photo_id'] = $photo_id;
    }
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    if(!isset($photo_id))
    {
        if($upload == true)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            redirect($errorURL);
        }
        else
        {
            $_SESSION['error'] = 'Error! You need to select a photo to edit.';
            $_SESSION['redirect'] = $profileURL;
            redirect($errorURL);
        }
    }
    else
    {
        // ######## add to views.php!!!!
        $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
        $result = sql($query);
        $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
        $result_photo = sql($query);
        while($row = mysql_fetch_array($result_photo))
        {
            $photo_title = $row[title];
            $pathname = $row[path];
            $private = $row['private'];
            $album_id = $row[album_id];
            $description = $row[description];;
        }
        $query = "select id, type, text from tags where photo_id = '".$photo_id."';";
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