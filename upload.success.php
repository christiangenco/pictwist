<?php 

    // filename: upload.success.php
    
    // current working directory, relative to the root (AKA: /pictwist/)
    $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
    //echo "self: " . $directory_self . '<br/>';
    
    // URL of user profile page script (AKA profile.php)
    $profile = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'profile.php';
    //echo $index . '<br/>';
    
    header("Refresh: 2; URL='$profile'"); 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd"> 

<html> 
    <head> 
         
        <title>Successful Upload</title> 
     
    </head> 
     
    <body> 
     
        <div id="Upload"> 
            <h1>File upload</h1> 
            <p>Congratulations! Your file upload was successful</p> 
        </div> 
     
    </body> 

</html> 