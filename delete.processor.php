<?php INCLUDE 'include/head.php';?>
<?php
    //echo "deleting...<br/>";
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to delete photos!");
    //echo "deleting...<br/>";
    if(isNotNull($_REQUEST['p_id']))
    {
        $p_id = params('p_id');
        //echo "owner: " . isOwner($p_id) . " admin: " . isAdmin() . " ";
        errorRedirect(!isOwner($p_id)||!isAdmin(), "Error! You do not have permission to delete this photo!", $profileURL);
    }

    else
    {
        errorRedirect(TRUE, "Error! You have not selected a photo for deletion.", $profileURL);
    }
    $p_id = params('p_id');
    
    $query = "SELECT path FROM Photos WHERE id=".$p_id.";";
    //echo $query . "<br/><br/>";
    $result_path = sql($query);
    
    if($row = mysql_fetch_array($result_path))
    {
        unlink($row['path']);

    }
    $query = "Delete from Photos WHERE id = ".$p_id;
    //echo $query . "<br/><br/>";
    $result = sql($query); 

    errorRedirect(!$result, "Error! Photo could not be deleted.", $viewURL);
    errorRedirect(!$result_path, "Error! Photo is not in the database.", $profileURL);
    redirect($profileURL);
?>
<?php INCLUDE 'include/foot.php' ?>