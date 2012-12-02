<?php INCLUDE 'include/head.php';?>
<?php
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to edit photos!");
    connectToDb();
    errorRedirect(!isNotNull($_REQUEST['p_id']) || !isNotNull($_REQUEST['a_id']), 'Error! No photo selected for editing.', $profileURL);
    connectToDb();
    $photo_id = $_REQUEST['p_id'];
    $album_id = $_REQUEST['a_id'];
    errorRedirect(!isOwner($photo_id), "Error! You do not have permission to edit this photo!", $viewURL."?p_id=".$photo_id."&a_id=".$album_id);
    // update photo info

    if(isNotNull($_REQUEST['private']))
    {
        $private = $_REQUEST['private'];
        $query = "Update photos SET private = ". $private . " where id = " . $photo_id . ";";
         echo "<br/>".$query;
        $result = sql($query);
        
        if(!$result)
        {
            errorRedirect(!$result, "Photo information could not be updated.", $editURL."?p_id=".$photo_id."&a_id=".$album_id);
        }   
        else
        {
            
            redirect($editURL."?p_id=".$photo_id."&a_id=".$album_id);
        }
    }

    else
    {
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

        if(isset($_SESSION['color']))
        {
            $colors = $_SESSION['color'];
            unset($_SESSION['color']);
            echo "colors: "; print_r($colors); echo " ".$colors[1]." ggg<br/>";
            foreach($colors as $c)
            {
                if($c != "")
                {

                    $query = "insert into tags(type, text, photo_id) values('color', '" . $c . "', " . $photo_id . ");";
                     echo "<br/>".$query;
                    $result_temp = sql($query);
                    //if(!$result_temp){$result++;}
                }
                
            }
        }
        
        if(isset($_SESSION['info']))
        {
            $info = $_SESSION['info'];
            unset($_SESSION['info']);
            //echo "colors: "; print_r($colors); echo " ".$colors[1]." ggg<br/>";
            if(isNotNull($info['height']))
            {
                $i = $info['height'];
                $query = "insert into tags(type, text, photo_id) values('height', '" . $i . "', " . $photo_id . ");";
                echo "<br/>".$query;
                $result_temp = sql($query);
            }
            if(isNotNull($info['width']))
            {
                $i = $info['width'];
                $query = "insert into tags(type, text, photo_id) values('width', '" . $i . "', " . $photo_id . ");";
                echo "<br/>".$query;
                $result_temp = sql($query);
            }
            if(isNotNull($info['camera_model']))
            {
                $i = $info['camera_model'];
                $query = "insert into tags(type, text, photo_id) values('camera', '" . $i . "', " . $photo_id . ");";
                echo "<br/>".$query;
                $result_temp = sql($query);
            }
            if(isNotNull($info['date_taken']))
            {
                $i = $info['date_taken'];
                $query = "insert into tags(type, text, photo_id) values('date', '" . $i . "', " . $photo_id . ");";
                echo "<br/>".$query;
                $result_temp = sql($query);
            }
        }
        
        errorRedirect(!$result, "Photo information could not be updated.", $editURL."?p_id=".$photo_id."&a_id=".$album_id);

        // add new tags
        $result = 0;
        foreach($_POST['tag'] as $index=>$type)
        {
            if($_POST['tagContent']['index'] != "")
            {
                $query = "insert into tags(type, text, photo_id) values('" . $_POST['tag'][$index] . "', '" . $_POST['tagContent'][$index] . "', " . $photo_id . ");";
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
            $_SESSION['redirect'] = $editURL."?p_id=".$photo_id."&a_id=".$album_id;
            //redirect($errorURL);
        }
        
        if(isset($_SESSION['error']) && isset($_SESSION['redirect']))
        {
            redirect($errorURL);
        }
        else
        {
            redirect($viewURL."?p_id=".$photo_id."&a_id=".$album_id);
        } 
    }
    
?>
<?php INCLUDE 'include/foot.php' ?>