<?php INCLUDE 'include/head.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to edit photos!");
    connectToDb();
    errorRedirect(!isNotNull($_SESSION['photo_id']), 'Error! No photo selected for editing.', $profileURL);
    connectToDb();
    $photo_id = $_SESSION['photo_id'];
    errorRedirect(!isOwner($photo_id), "Error! You do not have permission to edit this photo!", $viewURL);
    // update photo info
    if(isNotNull($_POST['title']))
    {
        $title = "\"".params('title')."\"";
        $query = "Update photos SET title = ". $title . " where id = " . $photo_id . ";";
         echo "<br/>".$query;
        $result = sql($query);
    }
    
    // -> update private/public
    // -> update description
    if(isNotNull($_POST['description']))
    {
        $description = "\"".params('description')."\"";
        $query = "Update photos SET description = '". $description . "' where id = " . $photo_id . ";";
         echo "<br/>".$query;
        $result = sql($query);
    }
    
    errorRedirect(!$result, "Photo information could not be updated.", $editURL);

    // add new tags
    $result = 0;
    foreach($_POST['tag'] as $index=>$type)
    {
        if($_POST['tagContent']['index'] != "")
        {
            $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'][$index] . "', '" . $_POST['tagContent'][$index] . "', '" . $_SESSION['photo_id'] . "');";
             echo "<br/>".$query;
            $result_temp = sql($query);
            if(!$result_temp){$result++;}
        }
    }
    if($result > 0)
    {
        $temp = "";
        if(isset($_SESSION['error']))
        {
            $temp = $_SESSION['error'];
        }
        $temp = $temp . $result . " tags could not be added.";
        $_SESSION['error'] = $temp;
        $_SESSION['redirect'] = $editURL;
        //redirect($errorURL);
    }
    
    if(isset($_SESSION['error']) && isset($_SESSION['redirect']))
    {
        redirect($errorURL);
    }
    else
    {
        redirect($viewURL);
    } 
?>
<?php INCLUDE 'include/foot.php' ?>