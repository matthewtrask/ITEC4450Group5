
<?
//executes common.php, starts session, and database connection 
require("common.php");
//used to display user's username if they enter the password incorrectly
$submitted username = "";
//checks if login form has been submitted if not the form is displayed
if(!empty($_POST)) 
    { 
//retrieves the user info based on their username
$query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
//parameter values
 $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
 try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
catch(PDOException $ex) 
        { 
//may not want to output this
die("Failed to run query: " . $ex->getMessage()); 
        } 
//this variable tells us if the user logins in or not
// it is initally set to false
//if the details are entered correctly it is switched to true
$login_ok = false; 
//gets the user data if the user is false then the wrong username was given
$row = $stmt->fetch(); 
        if($row) 
        { 
//uses the submitted password and the stored salt we check for a match 
//by hashing the values and comparing it to the stored hash.
$check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
		{
//If they do switch to true
 		$login_ok = true; 
            } 
        } 
//If the login was successful then they will be sent to a private page
//if not we display an error message
if($login_ok) 
        { 
//session will be stored but salt and password will be removed form the $row array
            unset($row['salt']); 
            unset($row['password']); 
//stores session details
           $_SESSION['user'] = $row; 
//redirects to the private page
	    header("Location: private.php"); 
            die("Redirecting to: private.php"); 
}
else
{
print("Login Failed."); 
//show them their username again
//they must enter a new password
 $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 
<h1>Login</h1> 
<form action="login.php" method="post"> 
    Username:<br /> 
    <input type="text" name="username" value="<?php echo $submitted_username; ?>" /> 
    <br /><br /> 
    Password:<br /> 
    <input type="password" name="password" value="" /> 
    <br /><br /> 
    <input type="submit" value="Login" /> 
</form> 
<a href="register.php">Register</a>