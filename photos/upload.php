<?php 
    session_start();
    // filename: upload.php 

    // current working directory, relative to the root (AKA: /pictwist/)
    $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 

    // URL of upload handler script (AKA upload.processor.php)
    $uploadHandler = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.processor.php';
    
    // URL of login script (AKA login.php) - in case of invalid login
    $login = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'login.php';
    //echo $login . '<br/>';
    
    // URL of user profile page script (AKA profile.php)
    $profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
    
    // URL of search script (AKA search.php)
    $search = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'search.php';
    
    // URL of upload script (AKA upload.php)
    $upload = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'upload.php';
    
    // URL of logout script (AKA killSession.php)
    $killSession = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'killSession.php';
    
    // URL of error script (AKA error.php)
    $error = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'error.php';
    
    // URL of view script (AKA view.php)
    $view = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'view.php';
    
    // URL of edit script (AKA edit.php)
    $edit = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'edit.php';

    // set a max file size for the html upload form 
    $max_file_size = 100000; // size in bytes (AKA 100 KB)
    
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

<html> 
    <head> 
        <title>Upload a Picture</title> 
        <style type="text/css">
            ul{list-style-type:none; margin:0; padding:0; background-color:blue; padding:5px;}
            li{display:inline; color:white; padding:0px 50px 0px 10px;}
            li a{color:white;}
	</style>
    </head> 
     
    <body>
        <ul>
            <li><a href="<?php echo $list ?>">My Photos</a></li>
            <li><a href="<?php echo $upload ?>">Upload Photos</a></li>
            <li><a href="<?php echo $search ?>">Search Photos</a></li>
            <li style="float:right;"><a href="<?php echo $killSession ?>">Logout</a></li>
        </ul>
     
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
         
     
    </body> 

</html> 