<?php INCLUDE_ONCE 'include/head.php'; ?>
<div id="user info">
<?php
    connectToDb();
	date_default_timezone_set('America/Chicago');
	if(!isset($_REQUEST['u_id']) && isLoggedIn())
    {
        $prof_id = $currentUser['id'];
        $uid = $currentUser['id'];

        $query = "SELECT a.id, a.title FROM albums a where a.user_id=".$prof_id.";";
        $result_albums = sql($query);

        $query = "SELECT a.id, a.title FROM albums a JOIN shared s WHERE a.id=s.album_id AND s.user_id=".$prof_id.";";
        $shared_albums = sql($query);
        //this is your profile page: pull all your albums and all shared with you
       
/*      $query = "select id, title from albums where user_id=".$uid.";";
        $result_albums = sql($query);
        
        $query2 = "select a.id, a.title from albums a join shared on $uid = shared.user_id and shared.album_id = a.id;";
        $shared_albums = sql($query2);
        */
    }
    else if(isAdmin() && $_REQUEST['u_id'])
    {
        $prof_id = params('u_id');
        $uid = $currentUser['id'];

        $query = "SELECT a.id, a.title FROM albums a where a.user_id=".$prof_id.";";
        $result_albums = sql($query);

        $shared_albums = 0;
    }
    else if(isset($_REQUEST['u_id']) && isLoggedIn())
    {
        $prof_id = params('u_id');
        $uid = $currentUser['id'];

        if($prof_id == $uid)
        {
            $query = "SELECT a.id, a.title FROM albums a where a.user_id=".$prof_id.";";
            $result_albums = sql($query);

            $query = "SELECT a.id, a.title FROM albums a JOIN shared s WHERE a.id=s.album_id AND s.user_id=".$prof_id.";";
            $shared_albums = sql($query);
        }
        else
        {
           $query = "SELECT a.id, a.title FROM albums a LEFT JOIN shared s ON a.id=s.album_id WHERE a.private=0 OR (a.user_id=".$prof_id." && s.user_id=".$uid.");";
           $result_albums = sql($query);
           $shared_albums = 0; 
        }
        
        //search public albums and shared with me albums
    }
    else if(isset($_REQUEST['u_id']) && !isLoggedIn())
    {
        $prof_id = params('u_id');
        $uid = -1;

        $query = "SELECT a.id, a.title FROM albums a where a.private=0 AND a.user_id=".$prof_id.";";
        $result_albums = sql($query);
        $shared_albums = 0;
        //search only public albums
    }
    else
    {
        $_SESSION['error'] = 'Error! You must be logged in to view your albums!';
        redirect($logoutURL);

        //can't view your profile page, bc !logged in
    }

    $query = mysql_query("SELECT id, created_at, name, city, state, country, bio, updated_at, admin FROM users WHERE id='$prof_id';");
    //echo "<br> QUERY: " . $query;
    if($row = mysql_fetch_array($query))
    {   
        $id = $row['id'];
        $tstamp = $row['created_at'];
        $lastUpdate = $row['updated_at'];
        $name = $row['name'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $bio = $row['bio'];
        $admin = $row['admin'];
    } 
?>
<form id="myProfile" action="<?php echo $baseURL . 'profile.php' ?>" enctype="multipart/form-data" method="post"> 

    <h1> 
        <? echo $name."'s Profile"; ?></h1> 
        <?php if($uid==$prof_id):?>
     <img src="<? echo $currentUser['profile_picture_path'] ?>" width="300px" height="300px" alt="profile picture" style="float:right" />
        <?php endif; ?>
    <p>
        
    <?php
        echo "<br><b>Name: </b>" . $name;
        if(!empty($city))
        {
            echo "<br><b>City: </b>" . $city;   
        }
        if(!empty($state))
        {
            echo "<br><b>State: </b>" . $state;
        }
        if(!empty($country))
        {
            echo "<br><b>Country: </b>" . $country; 
        }
        if(!empty($bio))
        {
            echo "<br><b>About me: </b>" . $bio;
        }       
        echo "<br><b>Member since </b>" . date("F j, Y", strtotime($tstamp));
        echo "<br><b>Last login was </b>" . date("F j, Y", strtotime($lastUpdate)); 

        if($uid <> $prof_id && $uid > 0)
        {
            echo '<br/><a href="'.$flagContentURL.'?u_id='.$id.'">Report User</a>';
            echo '<br/><a href="'.$subscriptionHandlerURL.'?u_id='.$id.'">Subscribe</a>';
        }

        ?>
    <br/>
    </p>  
</form>
    <?php if($uid == $prof_id): ?>
    <form method="post" action="editInfo.php">
        <input type="submit" value="Edit My Account">
    </form>
    <?php endif;?>
    <?php if(isAdmin() && $uid == $prof_id):?>
    <form method="post" action="admin.php">
        <input type="submit" value="Administrator">
    </form>
    <?php endif; ?>
    
</div>
<div id="album info">

<form id="MyAlbums" action="<?php echo $baseURL . 'album.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1>
        <?php 
        if($uid == $prof_id)
            echo "My Albums";
        else
            echo "Albums";
        ?> 
    </h1> 
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php
                while($row = mysql_fetch_array($result_albums))
                {
                	//fixes earlier problem
                    echo '<a href="album.photos.php?album_id=' . $row["id"] . '">' . $row["title"] . '</a><br/>';
                }
                    echo '<a href="favorite.display.php">Favorites</a><br/>';
                    echo '<a href="albums.php">Add a new album</a><br/>';
            ?>

        <br/>
    </p> 
</form>

<?php if($uid == $prof_id): ?>
<form id="MySharedAlbums" action="<?php echo $baseURL . 'album.shared.photos.php' ?>" enctype="multipart/form-data" method="post"> 
 
    <h1> 
    	<?php 
    	if($uid == $prof_id)
    		echo "My Shared Albums";
    	else
    		echo "Albums Shared with Me";
        ?> 
    </h1> 
     
    <p> 
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size ?>"> 
    </p> 
    
    <p>
        <?php
                while($row = mysql_fetch_array($shared_albums))
                {
                    echo '<a href="album.shared.photos.php?album_id=' . $row["id"] . '">' . $row["title"] . '</a><br/>';
                }
            ?>

        <br/>
    </p> 
</form>

<form id="Add Photo" action="<?php echo $uploadURL ?>" enctype="multipart/form-data" method="post">
    <p>
        <input type="submit" name="Add Photo" value="Add Photo" />
    </p> 
</form> 
<?php endif; ?>

</div>
<?php INCLUDE 'include/foot.php' ?>