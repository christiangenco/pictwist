<?php INCLUDE 'include/head.php';?>
<?php
    connectToDb();
    redirect_if_not_logged_in($logoutURL, "Error! You must be logged in to edit photos!");
    errorRedirect(isRestrictedPhoto($_REQUEST['p_id'], $_REQUEST['a_id']), "Error! You do not have permission to view this photo.", $indexURL);
    if(isNotNull($_REQUEST['p_id']) && isNotNull($_REQUEST['a_id']))
    {
        $photo_id = params('p_id');
        $album_id = params('a_id');
        //$_SESSION['photo_id'] = $photo_id;
    }
    /*
    else if(isset($_SESSION['photo_id']))
    {
        $photo_id = $_SESSION['photo_id'];
    }
    */
    errorRedirect(!isNotNull($photo_id), 'Error! You need to select a photo to edit.', $indexURL);
   
    $query = "UPDATE photos SET views = views + 1 WHERE id = ".$photo_id.";";
    $result = sql($query);
    $query = "select title, description, path, private, album_id from photos where id = '".$photo_id."';";
    $result_photo = sql($query);
    if($row = mysql_fetch_array($result_photo))
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
    if(isNotNull($photo['id'])) {$photo_id = $photo['id'];}
    if(isNotNull($photo['album_id'])) {$album_id = $photo['album_id'];}
    $query = "select id, type, text from tags where photo_id = '".$photo_id."';";
    $result_tags = sql($query);

    
    
?>

<form id="twist" action="<?php echo $uploadHandlerURL."?p_id=".$photo_id; ?>" method="post" enctype="multipart/form-data"> 
    <div class="pic" >
        <div id="canvas_wrapper" width="<? echo $photo['width'] ?>" height="<? echo $photo['height'] ?>">

        </div>
        <div>
            <div id="picTwister" class="wPaint_demobox" style="position:relative; width:<? echo $photo['width'] ?>px; height:<? echo $photo['height'] ?>px"></div>
            <!-- <div id="editControls">
                <a href="#"><img src="img/moustache.png" width="50px" /></a>
            </div> -->
        </div>

        <div style="clear:both"></div>

    </div>
    Select Album:
    <select name="a_id">
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