<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    $upload = false;
    if(!isset($currentUser['id']) || $currentUser['id'] <= 0)
    {
        $_SESSION['error'] = 'Error! You must be logged in to upload photos!';
        redirect($logoutURL);
    } 
    if(isset($_SESSION['photo_path']) && isset($_SESSION['album_id']))
    {
        $album_id = $_SESSION['album_id'];
        $pathname = $_SESSION['photo_path'];
        unset ($_SESSION['album_id']);
        unset ($_SESSION['photo_path']);

        $query = "insert into photos(path, album_id) values('" . $pathname . "', " . $album_id . ");";
        $result = sql($query);
        if(!$result)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            unlink($pathname);
            redirect($errorURL);
        }
        else
        {
            $query = "select id from photos where path = '".$pathname."';";
            $result_id = sql($query);
            while($row = mysql_fetch_array($result_id))
            {
                $photo_id = $row[id];
            }
            $_SESSION['photo_id'] = $photo_id;
            $upload = true;
        }
        //"select title, path from photos where id='$pid';";
    }
    else if(isset($_REQUEST['p_id']))
    {
        $photo_id = $_REQUEST['p_id'];
        $_SESSION['photo_id'] = $photo_id;
    }
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    if(!isset($photo_id))
    {
        if($upload == true)
        {
            $_SESSION['error'] = 'Error! Your photo could not be uploaded. Please try again.';
            $_SESSION['redirect'] = $uploadURL;
            redirect($errorURL);
        }
        else
        {
            $_SESSION['error'] = 'Error! You need to select a photo to edit.';
            $_SESSION['redirect'] = $profileURL;
            redirect($errorURL);
        }
    }
    else
    {
        // ######## add to views.php!!!!
        $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
        $result = sql($query);
        $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
        $result_photo = sql($query);
        while($row = mysql_fetch_array($result_photo))
        {
            $size = getimagesize($row['path']);
            $photo = array(
                "id" => $photo_id,
                "title" => $row['title'],
                "path" => $row['path'],
                "private" => $row['private'],
                "album_id" => $row['album_id'],
                "description" => $row['description'],
                "width" => $size[0],
                "height" => $size[1]
            );
        }
        if(isset($photo['id'])) {$_SESSION['parent'] = $photo['id'];}
        $query = "select id, type, text from tags where photo_id = '".$photo['id']."';";
        $result_tags = sql($query);
    }
    
    
?>

<form id="twist" action="<?php echo $uploadHandlerURL ?>" method="post" enctype="multipart/form-data"> 
    <div class="pic" >
        <div id="canvas_wrapper" width="<? echo $photo['width'] ?>" height="<? echo $photo['height'] ?>">

        </div>
        <div>
            <div id="picTwister" class="wPaint_demobox" style="position:relative; width:<? echo $photo['width'] ?>px; height:<? echo $photo['height'] ?>px"></div>
            <!-- <div id="editControls">
                <a href="#"><img src="img/moustache.png" width="50px" /></a>
            </div> -->
        </div>

        <div style="clear:both" />

    </div>
    Select Album:
    <select name="album_id">
        <?php
            $uid = $currentUser['id'];
            $query = "select id, title from albums where user_id='".$uid."';";
            $result_albums = sql($query);
            while($row = mysql_fetch_array($result_albums))
            {
                if($row[title] != 'Favorites')
                {
                    echo '<option value="' . $row[id] . '">' . $row[title] . '</option>';
                }
            }
        ?>
    </select>
    <br />
    <input type='hidden' name='file' id="file" />

    <input type="submit" name="saveImage" id="saveImage" value="Save" onclick="saveImage;"> 
 
</form> 

<img id="canvasImage" />

<br/>

<!-- Custom CSS/JS for this page -->
<link rel="stylesheet" type="text/css" href="styles/wPaint.css" />
<link rel="stylesheet" type="text/css" href="styles/wColorPicker.css" />
<script type="text/javascript" src="js/wColorPicker.js"></script>
<script type="text/javascript" src="js/wPaint.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#picTwister").wPaint({
            imageBg: "<? echo $photo['path'] ?>",
            fillStyle: '#000',
            fontSizeMin: '18',
            fontSizeMax: '50',
            fontSize: '25',
            lineWidthMin: 2,
            lineWidthMax: 20,
            fontTypeBold: true,
            // menu: ['undo','clear','rectangle','ellipse','line','pencil','text','eraser','fillColor','lineWidth','strokeColor'] // menu items - appear in order they are set
            menu: ['undo','clear','line','pencil','text','eraser','lineWidth','strokeColor']
            // image: "<? echo $pathname ?>"
        });

        $("#saveImage").click(function(e){
            var imageData = $("#picTwister").wPaint("image");
            // $("#canvasImage").attr("src", imageData);

            $('#file').val(imageData);

            // e.preventDefault();

        });
    });
</script>

<?php INCLUDE 'include/foot.php' ?>