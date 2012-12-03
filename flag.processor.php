<?php INCLUDE 'include/head.php';?>
<?php
    
    connectToDb();
    
    if(isNotNull($_REQUEST['p_id'])&&isNotNull($_REQUEST['a_id'])&&isNotNull($_REQUEST['t_id']))
    {
        $p_id = params('p_id');
        $a_id = params('a_id');
        $t_id = params('t_id');
        $query = mysql_query("SELECT * from flagged f where f.content_type='tags' AND f.content_id=$t_id;");
        if(mysql_numrows($query) ==0)
        {
            //id was NOT found - therefore the user/email is not registered     
            $query = "INSERT into flagged(content_type, content_id) VALUES('tags', $t_id);";
            $result = sql($query);
        }
        else 
        {
            $query = mysql_query("UPDATE flagged SET priority=priority+1 WHERE content_id='$t_id' AND content_type='tags';");
            echo $query . "<br/>";
            $_SESSION['error'] = "This tag has been reported.";
            $_SESSION['redirect'] = $viewURL."?p_id=".$p_id."&a_id=".$a_id;
            redirect($errorURL);
        }
    } 
    else if(isNotNull($_REQUEST['p_id'])&&isNotNull($_REQUEST['a_id'])&&isNotNull($_REQUEST['c_id']))
    {
        $p_id = params('p_id');
        $a_id = params('a_id');
        $c_id = params('c_id');
        $query = mysql_query("SELECT * from flagged f where f.content_type='comments' AND f.content_id=$c_id;");
        if(mysql_numrows($query) ==0)
        {
            //id was NOT found - therefore the user/email is not registered     
            $query = "INSERT into flagged(content_type, content_id) VALUES('comments', $c_id);";
            $result = sql($query);
            $_SESSION['error'] = "This comment has been reported.";
            $_SESSION['redirect'] = $viewURL."?p_id=".$p_id."&a_id=".$a_id;
            redirect($errorURL);
        }
        else 
        {
            $query = mysql_query("UPDATE flagged SET priority=priority+1 WHERE content_id='$t_id' AND content_type='comments';");
            echo $query . "<br/>";
            $_SESSION['error'] = "This comment has been reported.";
            $_SESSION['redirect'] = $viewURL."?p_id=".$p_id."&a_id=".$a_id;
            redirect($errorURL);
        }
    } 
    else if(isNotNull($_REQUEST['p_id'])&&isNotNull($_REQUEST['a_id']))
    {
        $p_id = params('p_id');
        $a_id = params('a_id');
        $query = mysql_query("SELECT * from flagged f where f.content_type='photos' AND f.content_id=$p_id;");
        if(mysql_numrows($query) ==0)
        {
            //id was NOT found - therefore the user/email is not registered     
            $query = "INSERT into flagged(content_type, content_id) VALUES('photos', $p_id);";
            $result = sql($query);
            $_SESSION['error'] = "This photo has been reported.";
            $_SESSION['redirect'] = $viewURL."?p_id=".$p_id."&a_id=".$a_id;
            redirect($errorURL);
        }
        else 
        {
            $query = mysql_query("UPDATE flagged SET priority=priority+1 WHERE content_id='$p_id' AND content_type='photos';");
            echo $query . "<br/>";
            $_SESSION['error'] = "This photo has been reported.";
            $_SESSION['redirect'] = $viewURL."?p_id=".$p_id."&a_id=".$a_id;
            redirect($errorURL);
        }
    } 
    else if(isNotNull($_REQUEST['u_id']))
    {
        $u_id = params('u_id');
        $query = mysql_query("SELECT * from flagged f where f.content_type='users' AND f.content_id=$u_id;");
        if(mysql_numrows($query) ==0)
        {
            //id was NOT found - therefore the user/email is not registered     
            $query = "INSERT into flagged(content_type, content_id) VALUES('users', $u_id);";
            $result = sql($query);
            $_SESSION['error'] = "This user has been reported.";
            $_SESSION['redirect'] = $profileURL."?u_id=".$u_id;
            redirect($errorURL);
        }
        else 
        {
            $query = mysql_query("UPDATE flagged SET priority=priority+1 WHERE content_id='$u_id' AND content_type='users';");
            echo $query . "<br/>";
            $_SESSION['error'] = "This user has been reported.";
            $_SESSION['redirect'] = $profileURL."?u_id=".$u_id;
            redirect($errorURL);
        }
    } 
    else
    {
        errorRedirect(TRUE, "Error! You have not selected any content for flagging.", $indexURL);
    }
?>
<?php INCLUDE 'include/foot.php' ?>