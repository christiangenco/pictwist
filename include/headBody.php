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
              <a id="gotoSignIn" href="javascript:;" class="m-btn blue thinShadow">Log In</a><a  id="gotoRegister" href="<?php echo $registerURL;?>" class="m-btn blue thinShadow">Join PicTwist</a>
            </div>
          
          
          <div id="signInFormContainer">
            <form id="signInForm" enctype="multipart/form-data" method="post" action="<?php echo $loginHandlerURL ?>">
              <input id="usernameField" class="m-wrap" type="text" type="text" name="email" placeholder="E-mail" />
              <input id="passwordField" class="m-wrap" type="password" name="pwd" placeholder="Password" />
              <input id="signInBtn" class="m-btn icn-only blue thinShadow" type="submit" name="submit" value="Log In"/>
            </form>
      
            <i id="closeBtn"></i>
          </div>
          
          
          <? else: ?>
            <div id="userBadge">
              <img id="userPic" src="img/default_pic.png" />
              <div id="userInfo">
                <div id="userName"><?echo $currentUser['username'];?></div>
                <div id="userLinks"><a href="<?php echo $profileURL;?>">My Profile</a> | <a href="<?php echo $logoutURL;?>">Sign out</a></div>
              </div>
            </div>
            
          <? endif; ?>
          
        </div>         



        <div id="searchContainer">
          <form id="searchForm" method="get" action=<?php echo $searchURL;?>>
            <input id="searchField" class="m-wrap" name="query" type="text" placeholder="Search for photos" value="<? if (isset($_REQUEST['query'])) {echo $_REQUEST['query'];} ?>"/>
            <a id="searchBtn" class="m-btn icn-only blue thinShadow"><i class="icon-search icon-white"></i></a>
          </form>
        </div>          
        
      </div>
    </div>    
    
    
    
    <div id="content">