<?php INCLUDE 'include/head.php';?>
<?php INCLUDE 'photo.info.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to edit photos!");
    connectToDb();
    $upload = FALSE;
    //echo "hey there<br/>";

    if(isset($_REQUEST['p_path']) && isNotNull($_REQUEST['p_path']) && isNotNull($_REQUEST['a_id']))
    {
        //echo "in here<br/>";
        $a_id = params('a_id');
        $pathname = params('p_path');
        //echo "in here<br/>";
        $colors = getPhotoColors($pathname);
        //echo "in here<br/>";
        $colors = array_unique($colors);
        //echo "in here<br/>";
       
        $info = getPhotoInfo($pathname);
        $_SESSION['info'] = $info;
        $_SESSION['color'] = $colors;
        //unset ($_REQUEST['album_id']);
        //unset ($_REQUEST['photo_path']);

        if(isset($_SESSION['parent']))
        {
            $query = "insert into photos(path, parent_photo_id, album_id) values('" . $pathname . "', " . $_SESSION['parent'] . ", " . $a_id . ");";
            unset($_SESSION['parent']);
            //echo $query . "<br/>";
        }
        else
        {
            $query = "insert into photos(path, album_id) values('" . $pathname . "', " . $a_id . ");";
            //echo $query . "<br/>";
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
            $query = "select id, album_id from photos where path = '".$pathname."';";
            //echo $query . "<br/>";
            $result_id = sql($query);
            if($row = mysql_fetch_array($result_id))
            {
                $p_id = $row['id'];
                $a_id = $row['album_id'];
            }
            //$_SESSION['photo_id'] = $photo_id;
            $upload = TRUE;
        }
        //"select title, path from photos where id='$pid';";
    }
    else if(isNotNull($_REQUEST['p_id']) && isNotNull($_REQUEST['a_id']))
    {
        $p_id = params('p_id');
        $a_id = params('a_id');
        //$_SESSION['photo_id'] = $photo_id;
    }
    /*
    else if(isNotNull($_SESSION['photo_id']))
    {
        $photo_id = params('photo_id');
    }
    */
    if(!isNotNull($p_id) || !isNotNull($a_id))
    {
        errorRedirect($upload, 'Error! Your photo could not be uploaded. Please try again.', $uploadURL);
        errorRedirect(!$upload, 'Error! You need to select a photo to edit.', $profileURL);
    }
    else
    {
        // ######## add to views.php!!!!
        //echo "owner: " . isOwner($photo_id);
        //header("Location: $loginURL");
        errorRedirect(!isOwner($p_id), "Error! You do not have permission to edit this photo!", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
        $query = "UPDATE photos SET views = views + 1 WHERE id = ".$p_id.";";
        //echo $query . "<br/>";
        $result = sql($query);
        $query = "select title, description, path, private, album_id from photos where id = ".$p_id.";";
        //echo $query . "<br/>";
        $result_photo = sql($query);
        errorRedirect(!$result_photo, "Error! No photo selected for editing.", $profileURL);
        while($row = mysql_fetch_array($result_photo))
        {
            $photo_title = $row['title'];
            $pathname = $row['path'];
            $private = $row['private'];
            $album_id = $row['album_id'];
            $description = $row['description'];
        }
        $query = "select id, type, text from tags where photo_id = ".$p_id.";";
        //echo $query . "<br/>";
        $result_tags = sql($query);
        
    }
    
    
?>

<p>Your photo: <?php echo $p_id;?></p>
<form id="Insert" action="<?php echo $editHandlerURL.'?p_id='.$p_id.'&a_id='.$album_id; ?>" enctype="multipart/form-data" method="post"> 
    <div class="pic" ><!--style="float:top; float:left; padding:50px;"-->
        <img src="<?php echo $pathname;?>" alt="<?php echo $pathname;?>" width=400 height=400/>
        <p>
            Album: <?php echo $album_id ?> <br/>
            Title: <input type="text" name="title" value=<?php echo $photo_title;?>><br/>
            Description: <br/>
            <textarea type="textarea" name="description" value=<?php echo $description;?>></textarea><br/>
            Visibility: 
            <? if($private==0): ?>
                <a href="<?php echo $editHandlerURL.'?p_id='.$p_id.'&a_id='.$album_id.'&private=1'; ?>">private</a>
                |
                public
            <? else: ?>
                private
                |
                <a href="<?php echo $editHandlerURL.'?p_id='.$p_id.'&a_id='.$album_id.'&private=0'; ?>">public</a>
            <? endif ?>
        </p>
    </div>
    <div id="tagsFields">
        Tags: <br/>
        <table>
            <?php
                while($row = mysql_fetch_array($result_tags))
                {
                    echo '<tr>'
                        .'<td><a href='.$deleteTagURL.'?a_id='.$album_id.'&p_id='.$p_id.'&t_id='.$row['id'].'>X </a></td>'
                        .'<td>'.$row['type'].': </td>'
                        .'<td>'.$row['text'].'</td>'
                        .'</tr>';
                }
            ?>
        </table>
    </div>
    <input type="hidden" name="color[]" value="<?php print_r($colors);?>">
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
          newdiv.innerHTML = "<select name='tag[]'>"
            +"<option value='location'>Location</option>"
            +"<option value='keyword'>Keyword</option>"
            +"<option value='person'>Person</option>"
            +"</select>" 
            +"<input type='text' name='tagContent[]' placeholder='tag'><br/>";
          document.getElementById('tagsFields').appendChild(newdiv);
    }
</script>
<?php INCLUDE 'include/foot.php' ?>