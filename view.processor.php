<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), "Error! No photo selected.", $indexURL, "_parent");
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to contribute!", $viewURL.'?p_id='.$photo_id.'&a_id='.$album_id, "_parent");
    $album_id = $_REQUEST['a_id'];
    $photo_id = $_REQUEST['p_id'];
    //echo "photo2: ". $photo_id . " album2:" . $album_id . "<br/>";
    errorRedirect(isRestrictedPhoto($photo_id, $album_id), "Error! You do not have permission to view this photo.", $indexURL, "_parent");

       if(isset($_POST['tagContent']) && $_POST['tagContent'] !== "")
        {
            if($_POST['tag'] == "person")
            {
                if(!isUser($_POST['tagContent']))
                {
                    errorRedirect(TRUE, "Error! This user does not exist.", $viewURL."?p_id=".$photo_id."&a_id=".$album_id, "_parent");
                }
                else
                {
                    $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'] . "', '" . $_POST['tagContent'] . "', '" . $_REQUEST['p_id'] . "');";
                    //echo $query . "<br/>";
                    $result = sql($query);
                    errorRedirect(!$result, "Tag could not be added.", $viewURL.'?p_id='.$photo_id.'&a_id='.$album_id, "_parent");
                }
            }
            else
            {
                $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'] . "', '" . $_POST['tagContent'] . "', '" . $_REQUEST['p_id'] . "');";
                //echo $query . "<br/>";
                $result = sql($query);
                errorRedirect(!$result, "Tag could not be added.", $viewURL.'?p_id='.$photo_id.'&a_id='.$album_id, "_parent");
            }
        }
        if(isset($_POST['comment']) && $_POST['comment'] !== "")
        {
            $query = "insert into comments(text, user_id, photo_id) values('" . $_POST['comment'] . "', '" . $currentUser[id] . "', '" . $_REQUEST['p_id'] . "');";
            $result = sql($query);
            errorRedirect(!$result, "Comment could not be posted.", $viewURL.'?p_id='.$photo_id.'&a_id='.$album_id, "_parent");
        }
        if($_POST['lightbox']){redirect($viewLightBoxURL.'?p_id='.$photo_id.'&a_id='.$album_id);}
        else
            {
                redirect($viewURL.'?p_id='.$photo_id.'&a_id='.$album_id, "_parent");
            }
?>
<?php INCLUDE 'include/foot.php' ?>