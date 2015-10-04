
<?php
    require("common.php"); 
//check to see if they're logged in or not
if(empty($_SESSION['user'])) 
    { 
//if they arent then they are redirected to login.php
        header("Location: login.php"); 
//need this
 die("Redirecting to login.php"); 
    } 
//everything below is secure
//use htmlentities b4 displaying it to the user
Hello <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>, secret content!<br /> 
<a href="memberlist.php">Memberlist</a><br /> 
<a href="edit_account.php">Edit Account</a><br /> 
<a href="logout.php">Logout</a>