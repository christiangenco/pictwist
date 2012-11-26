<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    if(isset($_SESSION['error']))
    {
        unset($_SESSION['error']);
    }
    if(isset($_REQUEST['p_id']))
    {
        connectToDb();
        
        $query = "Delete from Photos WHERE id = ".$_REQUEST['p_id'];
        $result = sql($query); 
        if(!$result)
        {
            $_SESSION['error'] = "Photo could not be deleted.";
            $_SESSION['redirect'] = $viewURL;
            redirect($errorURL);
        }
        redirect($profileURL);
    }
    else
    {
        $_SESSION['error'] = 'Error! No photo selected for deletion.';
        $_SESSION['redirect'] = $profileURL;
        redirect($errorURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>