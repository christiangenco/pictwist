<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to view this page!");
    errorRedirect(!isAdmin(), "Error! You do not have permission to view this this!", $indexURL);
    errorRedirect(!isNotNull($_REQUEST['comment']) || !isNotNull($_REQUEST['id']), "Error! No comment selected.", $adminURL);
    
    $c_content = $_REQUEST['comment'];
    $c_id = $_REQUEST['id'];
    

    $query = "update comments SET text = '".$c_content."' WHERE id= ".$c_id.";";
echo $query . "<br/>";
    $result = sql($query);
    if(!$result)
    {
        errorRedirect(!$result, "Comment could not be posted.", $adminURL);
    }
    else
    {
        redirect($adminURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>