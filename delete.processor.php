<?php INCLUDE 'include/head.php';?>
<?php
    //echo "deleting...<br/>";
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to delete photos!");
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), "Error! No photo selected for deletion.", $profileURL);
    $p_id = params('p_id');
    $a_id = params('a_id');
    if(!isOwner($p_id) && !isAdmin())
    {
        errorRedirect(!isOwner($p_id) && !isAdmin(), "Error! You do not have permission to delete this photo!", $profileURL);
    }
    else
    {
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

        errorRedirect(!$result, "Error! Photo could not be deleted.", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
        errorRedirect(!$result_path, "Error! Photo is not in the database.", $profileURL);
        redirect($profileURL);
    }
    
    
    //$p_id = params('p_id');
    
    
?>
<?php INCLUDE 'include/foot.php' ?>