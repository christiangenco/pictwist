<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    if(isset($_SESSION['error']))
    {
        unset($_SESSION['error']);
    }
    if(isset($_POST['submit']) && isset($_SESSION['photo_id']))
    {
        connectToDb();
        // update photo info
        if(isset($_POST['title']))
        {
            $title = "\"".$_POST['title']."\"";
            $query = "Update photos SET title = '". $title . "' where id = " . $_SESSION['photo_id'] . ";";
            $result = sql($query);
        }
        
        // -> update private/public
        // -> update description
        if(isset($_POST['description']))
        {
            $description = "\"".$_POST['description']."\"";
            $query = "Update photos SET description = '". $description . "' where id = " . $_SESSION['photo_id'] . ";";
            $result = sql($query);
        }
        
        if(!$result)
        {
            $_SESSION['error'] = "Photo information could not be updated.";
            $_SESSION['redirect'] = $editURL;
            //redirect($errorURL);
        }

        // add new tags
        $result = 0;
        foreach($_POST['tag'] as $index=>$type)
        {
            $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'][$index] . "', '" . $_POST['tagContent'][$index] . "', '" . $_SESSION['photo_id'] . "');";
            $result_temp = sql($query);
            if(!$result_temp){$result++;}
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
    } 
    else
    {
        $_SESSION['error'] = 'Error! No photo selected for editing.';
        $_SESSION['redirect'] = $profileURL;
        redirect($errorURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>