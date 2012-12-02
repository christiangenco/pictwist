<?php INCLUDE_ONCE 'include/headCode.php'; ?>
<head>
<title>PicTwist</title>
    <?php INCLUDE_ONCE 'include/cssAndJsIncludes.php'; ?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="fancyBox/source/jquery.fancybox.pack.js?v=2.1.3"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <link rel="stylesheet" href="fancyBox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
    <link href="styles/styles.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        $(document).ready(function() {
            //alert("Hey there");
            $(".fancybox").fancybox();
            
            $(".fancybox-iframe").fancybox({
                
                type : 'iframe',
                prevEffect : 'fade',
                nextEffect : 'fade',
                openEffect : 'none',
                closeEffect : 'none',
                margin : [20, 60, 20, 60],              
                
                closeBtn : true,
                arrows : true,
                nextClick : false,
                
                helpers: {
                    title : {
                        type : 'inside'
                    }
                },
                
                beforeShow: function() {
                    this.width = 1000;
                }
                
            });
            //alert("leaving...");
        });
    </script>

        <form method="post" action="editinfo.php">
            <input type="submit" value="My Account">
        </form>
</head>
<?php INCLUDE_ONCE 'include/headBody.php' ?>

<?php
    connectToDb();

    if(isset($currentUser['id']) && $currentUser['id'] > 0)
    {
        $uid = $currentUser['id'];
        $a_id = $_GET['album_id'];
        $sql = "SELECT title from albums where id=$a_id;";
        $result = sql($sql);
        $title = mysql_fetch_array($result);
        $query = "select id, title from photos where album_id='".$a_id."';";
        $result_photos = sql($query);
    }
    else
    {
            $_SESSION['error'] = 'Error! You must be logged in to view your photos!';
            redirect($logoutURL);
    } 
?>

<form id="AlbumPhotos" action="<?php echo $baseURL . 'album.photos.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
        <?php echo $title[title] ?>
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 

    <?php
        $query = "select a.title, p.id, p.path from albums a JOIN photos p where a.id = $a_id AND a.id = p.album_id AND user_id='$currentUser[id]' order by a.id desc;";
        $result = sql($query);
    
        echo '<div class="imageList_title"></div><div class="imageList">';
        while($row = mysql_fetch_array($result))
        {
            echo '<a id="' . $row["id"] . '" class="fancybox-iframe" rel="g1" href="'.$viewLightBoxURL.'?p_id=' . $row["id"] . '&a_id=' . $row["album_id"] . '">'.
                '<img src="'.$row["path"].'" alt="'.$row["title"].'"></a>';
        }
            echo '</div>';
    ?>
     
</form>

<form id="Add Photo" action="<?php echo $uploadURL ?>" enctype="multipart/form-data" method="post">
    <p>
        <input type="submit" name="Add Photo" value="Add Photo" />
    </p> 
</form> 

<form id="EditAlbum" action="<?php echo $baseURL . 'album.editor.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
    <p>
        <input type="submit" name="EditAlbum" value="Edit Album" />
    </p>
</form>

<form id="ShareAlbum" action="<?php echo $baseURL . 'album.share.php?album_id=' . $a_id ?>" enctype="multipart/form-data" method="post"> 
    <h1> 
        Share Album 
    </h1> 

    <p> 
        <label for="User">Name of user with whom you would like to share the album:</label> 
        <input id="user" type="text" name="username">
    </p>

    <p> 
        <label for="User">Email of user with whom you would like to share the album:</label> 
        <input id="user" type="text" name="useremail">
    </p>

    <p>
        <input type="submit" name="ShareAlbum" value="Share Album" />
    </p>
</form>

<?php INCLUDE 'include/foot.php' ?> 
