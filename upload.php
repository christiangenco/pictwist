<?php INCLUDE 'include/head.php'; ?>

<?php 

    // set a max file size for the html upload form 
    $max_file_size = 10000000; // size in bytes (AKA 10 MB)
    
    if(isset($_SESSION['uid']))
    {
            $uid = $_SESSION['uid'];
            
            $con = mysql_connect("localhost", "pictwist", 'secret');
            if(!$con)
            {
                    die('Could not connect: ' . mysql_error());
            }
        
            mysql_select_db("pictwist", $con)
                or die("Unable to select database: " . mysql_error());
            $query = "select id from albums where user_id='$uid' and title='Default';";
            $result = mysql_query($query);
            $row = mysql_fetch_array($result);
            $album_id = $row['id'];
            //echo "query: " . $query . '<br/>' . "result: " . $result . '<br/>' . "id: " . $album_id. '<br/>';
            if($album_id == "")
            {
                $_SESSION['error'] = "Error! The Album you selected does not exist.";
                $_SESSION['redirect'] = $upload;
                header('Location: ' . $error);
            }
            else
            {
                $_SESSION['album'] = $album_id;    
            }
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
            header('Location: ' . $killSession); 
    }
?>

<form id="Upload" action="<?php echo $uploadHandler ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        Upload a Picture! 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
     
    <p> 
        <label for="file">File to upload:</label> 
        <input id="file" type="file" name="file"> 
    </p> 
             
    <p> 
        <input id="submit" type="submit" name="submit" value="Upload me!"> 
    </p> 
 
</form> 
         
<?php INCLUDE 'include/foot.php' ?> 