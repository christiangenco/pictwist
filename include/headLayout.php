<!DOCTYPE html>
<head>
<title>PicTwist</title>
  <?php INCLUDE 'include/cssAndJsIncludes.php' ?>
  <link rel="shortcut icon" href="img/icon.ico" />
</head>
<body>
  
  <div id="pageContainer">  
    
    <div id="header_bg"></div>
    <div id="header">
    
      <a href="<? echo $baseURL ?>">
        <img id="logotext" src="img/logotext.png" />
        <img id="logoswirl" src="img/swirl.png" />
      </a>
      
      <div id="header_right">
      
        <div id="userBadgeContainer" class="thinShadow">
        
          <!-- only one of these will actually be shown -->
          <? if ($currentUser['id'] == -1): ?>
            <div id="notSignedIn">
              <a id="gotoSignIn" href="#" class="m-btn blue thinShadow">Sign In</a><a  id="gotoRegister" href="<?php echo $registerURL;?>" class="m-btn blue thinShadow">Join PicTwist</a>
            </div>
          
          
          <div id="signInFormContainer">
            <form id="signInForm" method="get" action="<?php echo $loginHandlerURL ?>">
              <input id="usernameField" class="m-wrap" type="text" type="text" name="email" placeholder="Email" />
              <input id="passwordField" class="m-wrap" type="password" name="pwd" placeholder="Password" />
              <a id="signInBtn" class="m-btn icn-only blue thinShadow">Sign In</a>
            </form>
      
            <i id="closeBtn"></i>
          </div>
          
          
          <? else: ?>
            <div id="userBadge">
              <img id="userPic" src="img/default_pic.png" />
              <div id="userInfo">
                <div id="userName"><?echo $currentUser['username'];?></div>
                <div id="userLinks"><a href="<?php echo $profileURL;?>">My Albums</a> | <a href="<?php echo $logoutURL;?>">Sign out</a></div>
              </div>
            </div>
            
          <? endif; ?>
          
        </div>              
      
        <div id="searchContainer">
          <form id="searchForm" action="<?php echo $searchURL;?>">
            <input id="searchField" class="m-wrap" type="text" placeholder="Search for photos" value="<? echo $_REQUEST['query'] ?>"/>
            <a id="searchBtn" class="m-btn icn-only blue thinShadow"><i class="icon-search icon-white"></i></a>
          </form>
        </div>          
        
      </div>
    </div>    
    
    
    
    <div id="content">