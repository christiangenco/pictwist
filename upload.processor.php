<?php INCLUDE 'include/head.php'; ?>

<?php
	redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to upload photos!");
    // directory that will recieve the uploaded file 
    $uploadsDirectory = getcwd().'/' . 'uploaded_files/';
    
    //relative path to image from current directory
    $localDirectory = 'uploaded_files/';
    
    // fieldname used within the file <input> of the HTML form 
    $fieldname = 'file';
    $uid = $currentUser['id'];

    // possible PHP upload errors 
    $errors = array(1 => 'php.ini max file size exceeded', 
                    2 => 'html form max file size exceeded', 
                    3 => 'file upload was only partial', 
                    4 => 'no file was attached');
    
    errorRedirect(
        !isNotNull($_REQUEST['album_id']), 
        'Error! You need to select an album to save you photo.', 
        $uploadURL);

    $album_id = params('album_id');// should come from a POST
    
    $now = time();

    if(isset($_POST[$fieldname])){
        // POST coming from twist.php
        $img = $_POST[$fieldname];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $pathname = $localDirectory.$now.'-'.'.png';
        $success = file_put_contents($pathname, $data);
    }else{
        // POST coming from upload.php
        // check for PHP's built-in uploading errors 
        ($_FILES[$fieldname]['error'] == 0) 
            or error($errors[$_FILES[$fieldname]['error']], $uploadURL); 
             
        // check that the file we are working on really was the subject of an HTTP upload 
        @is_uploaded_file($_FILES[$fieldname]['tmp_name'])
            or error('not an HTTP upload', $uploadURL); 
              
        // check to make sure the uploaded file is an image.
        // getimagesize() returns false if the file tested is not an image. 
        @getimagesize($_FILES[$fieldname]['tmp_name']) 
            or error('only image uploads are allowed', $uploadURL); 

        $pathname = $localDirectory.$now.'-'.$_FILES[$fieldname]['name'];
        
        // make a unique filename for the uploaded file and check it is not already taken
        // if it is already taken, keep trying until we find a vacant one 
        // sample filename: 1140732936-filename.jpg 
        while(file_exists($uploadFilename = $uploadsDirectory.$now.'-'.$_FILES[$fieldname]['name'])) 
        { 
            $now++;
            $pathname = $localDirectory.$now.'-'.$_FILES[$fieldname]['name'];
        }

        // move the file to its final location and allocate the new filename to it 
        @move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadFilename) 
            or error('receiving directory insuffiecient permission', $uploadURL); 
    }

    //$_SESSION['album_id'] = $album_id;
    //$_SESSION['photo_path'] = $pathname;
    redirect($editURL."?album_id=".$album_id."&photo_path=".$pathname);
    
    // The following function is an error handler which is used 
    // to output an HTML error page if the file upload fails 
    function error($error, $location, $seconds = 5) 
    { 
        header("Refresh: $seconds; URL='$location'"); 
        echo '    <div id="Upload">'. 
        '        <h1>Upload failure</h1>'. 
        '        <p>An error has occurred: '. 
        '        <span class="red">' . $error . '...</span>'. 
        '         The upload form is reloading</p>'. 
        '     </div>'; 
        exit; 
    } // end error handler 

?>

<?php INCLUDE 'include/foot.php' ?>