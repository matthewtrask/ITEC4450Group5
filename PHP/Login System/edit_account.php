<?php 
require("common.php"); 
//login check
if(empty($_SESSION['user'])) 
    { 
 header("Location: login.php"); 
//need this
 die("Redirecting to login.php"); 
    } 
//checks for edit form submission
//when it is the update code runs
//otherwise it displays
if(!empty($_POST)) 
    { 
//make sure a valid e-mail is entered
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
//makes sure the new e-mail doesn't conflict with an email in the system.
if($_POST['email'] != $_SESSION['user']['email']) 
        { 
//sql querie is defined here
 $query = " 
                SELECT 
                    1 
                FROM users 
                WHERE 
                    email = :email 
            "; 
//parameter are defined here
 $query_params = array( 
                ':email' => $_POST['email'] 
            ); 
             
            try 
            { 
//executes the query
	$stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
 catch(PDOException $ex) 
            { 
//may need to remove this?
 	die("Failed to run query: " . $ex->getMessage()); 
            } 
//if there are results to retrieve it retrieves them
 $row = $stmt->fetch(); 
            if($row) 
            { 
                die("This E-Mail is being used"); 
            } 
        } 
//password is hashed incase a new password is entered
if(!empty($_POST['password'])) 
        { 
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
            $password = hash('sha256', $_POST['password'] . $salt); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $password = hash('sha256', $password . $salt); 
            } 
        } 
        else 
        { 
//if a new password wasn't entered we won't update the old
	    $password = null; 
            $salt = null; 
        } 
//query parameter values
 $query_params = array( 
            ':email' => $_POST['email'], 
            ':user_id' => $_SESSION['user']['id'], 
        ); 
//if password is being changed we will need these parameters 
if($password !== null) 
        { 
            $query_params[':password'] = $password; 
            $query_params[':salt'] = $salt; 
        } 
$query = " 
            UPDATE users 
            SET 
                email = :email 
        "; 
//these are extened for password and salt columns
if($password !== null) 
        { 
            $query .= " 
                , password = :password 
                , salt = :salt 
            "; 
        } 
//now we state we want to update the current user info
$query .= " 
            WHERE 
                id = :user_id 
        "; 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
//may not be secure to include this
 die("Failed to run query: " . $ex->getMessage()); 
        } 
$_SESSION['user']['email'] = $_POST['email'];
//redirects user
header("Location: private.php"); 
//critical
die("Redirecting to private.php"); 
    } 
?> 
<h1>Edit Account</h1> 
<form action="edit_account.php" method="post"> 
    Username:<br /> 
    <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b> 
    <br /><br /> 
    E-Mail Address:<br /> 
    <input type="text" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /><br /> 
    <i>(leave blank if you do not want to change your password)</i> 
    <br /><br /> 
    <input type="submit" value="Update Account" /> 
</form>
