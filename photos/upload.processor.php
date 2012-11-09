<?php 
    session_start();
    // filename: upload.processor.php
    
    // current working directory, relative to the root (AKA: /pictwist/)
    $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
    
    // directory that will recieve the uploaded file 
    $uploadsDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . 'uploaded_files/';
    
    //relative path to image from current directory
    $localDirectory = 'uploaded_files/';
    
    // location of the upload form 
    $upload = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.php';
    
    // location of the success page 
    $success = 'http://' . $_SERVER['HTTP_HOST'] . $directory_self . 'upload.success.php';
    
    // URL of logout script (AKA killSession.php)
    $killSession = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'killSession.php';
    
    // URL of error script (AKA error.php)
    $error = 'http://'. $_SERVER['HTTP_HOST'] . $directory_self . 'error.php';
    
    // fieldname used within the file <input> of the HTML form 
    $fieldname = 'file'; 
    
    // possible PHP upload errors 
    $errors = array(1 => 'php.ini max file size exceeded', 
                    2 => 'html form max file size exceeded', 
                    3 => 'file upload was only partial', 
                    4 => 'no file was attached');
    
    if(isset($_SESSION['uid']) && isset($_SESSION['album']))
    {
        $uid = $_SESSION['uid'];
        $album_id = $_SESSION['album'];
    }
    else if(!isset($_SESSION['uid']))
    {
        $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
        header('Location: ' . $killSession); 
    }
    else
    {
        $_SESSION['error'] = 'Error! You need to select an album to save you photo.';
        $_SESSION['redirect'] = $upload;
        header('Location: ' . $error);
    }
    
    // check the upload form was actually submitted, else redirect to the upload form
    isset($_POST['submit']) 
        or error('the upload form is needed', $upload); 
    
    // check for PHP's built-in uploading errors 
    ($_FILES[$fieldname]['error'] == 0) 
        or error($errors[$_FILES[$fieldname]['error']], $upload); 
         
    // check that the file we are working on really was the subject of an HTTP upload 
    @is_uploaded_file($_FILES[$fieldname]['tmp_name']) 
        or error('not an HTTP upload', $upload); 
          
    // check to make sure the uploaded file is an image.
    // getimagesize() returns false if the file tested is not an image. 
    @getimagesize($_FILES[$fieldname]['tmp_name']) 
        or error('only image uploads are allowed', $upload); 
         
    // make a unique filename for the uploaded file and check it is not already taken
    // if it is already taken, keep trying until we find a vacant one 
    // sample filename: 1140732936-filename.jpg 
    $now = time();
    $pathname = $localDirectory.$now.'-'.$_FILES[$fieldname]['name'];
    while(file_exists($uploadFilename = $uploadsDirectory.$now.'-'.$_FILES[$fieldname]['name'])) 
    { 
        $now++;
        $pathname = $localDirectory.$now.'-'.$_FILES[$fieldname]['name'];
    } 
    
    // move the file to its final location and allocate the new filename to it 
    @move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename) 
        or error('receiving directory insuffiecient permission', $upload); 
         
    // At this point, file has successfully saved
    // Now going to add to database
    $con = mysql_connect("localhost", "pictwist", 'secret');
    if(!$con)
    {
            die('Could not connect: ' . mysql_error());
    }

    mysql_select_db("pictwist", $con)
	or die("Unable to select database: " . mysql_error());
    
    $query = "insert into photos(path, album_id) values('" . $pathname . "', " . $album_id . ");";
    $result = mysql_query($query);
    //echo "query: " . $query . '<br/>' . "result: " . $result . '<br/>' . "id: " . $album_id. '<br/>' . "path: " . $uploadFilename. '<br/>';
    
    mysql_close($con);
    
    if(!$result)
    {
        unlink($uploadFilename);
        error("Upload was unsuccessful. Please try again.", $upload);
    }
    
    // Now going to redirect the client to a success page. 
    header('Location: ' . $success); 
    
    // The following function is an error handler which is used 
    // to output an HTML error page if the file upload fails 
    function error($error, $location, $seconds = 5) 
    { 
        header("Refresh: $seconds; URL='$location'"); 
        echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"'. 
        '"http://www.w3.org/TR/html4/strict.dtd">'. 
        '<html>'. 
        '    <head>'. 
        '       <title>Upload error</title>'. 
        '    </head>'. 
        '    <body>'. 
        '    <div id="Upload">'. 
        '        <h1>Upload failure</h1>'. 
        '        <p>An error has occurred: '. 
        '        <span class="red">' . $error . '...</span>'. 
        '         The upload form is reloading</p>'. 
        '     </div>'. 
        '</html>'; 
        exit; 
    } // end error handler 

?> 