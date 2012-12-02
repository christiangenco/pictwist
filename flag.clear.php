<?php INCLUDE 'include/head.php';?>
<?php
    //echo "deleting...<br/>";
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to view this page!");
    errorRedirect(!isAdmin(), "Error! You do not have permission to view this this!", $indexURL);
    errorRedirect(!isNotNull($_REQUEST['fl_id']), "Error! No flag selected for deletion.", $adminURL);
    $fl_id = params('fl_id');

    $query = "DELETE from flagged WHERE id=".$fl_id.";";
    //$query = "SELECT photo_id FROM tags WHERE id=".$t_id." AND photo_id=".$p_id.";";
    $result = sql($query);
    /*
    if($row = mysql_fetch_array($result))
    {
        $photo_id = $row['photo_id'];
    }
    else
    {
        errorRedirect(TRUE, "Error! No tag selected.", $profileURL);
    }

    if(!isOwner($photo_id) && !isAdmin())
    {
        errorRedirect(!isOwner($photo_id) && !isAdmin(), "Error! You do not have permission to delete this tag!", $viewURL."?p_id=".$p_id."&a_id=".$a_id);
    }
    else
    {
        /*
        $query = "SELECT path FROM Photos WHERE id=".$p_id.";";
        //echo $query . "<br/><br/>";
        $result_path = sql($query);
        
        if($row = mysql_fetch_array($result_path))
        {
            unlink($row['path']);

        }
        
        $query = "Delete from tags WHERE id = ".$t_id;
        //echo $query . "<br/><br/>";
        $result = sql($query); 
*/
        if(!result)
        {
            errorRedirect(!$result, "Error! Flag could not be deleted.", $adminURL);
        }
        else
        {
            redirect($adminURL);
        }
        
    
    
    
?>
<?php INCLUDE 'include/foot.php' ?>