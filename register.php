
//that allows a user to create an account
<? 
//executes common.php and connects to database
//starts session
require("common.php");
//checks to see if registration form has been submitted
//if it has then the registration code is ran, otherwise a form is displayed. 
if(!empty($_POST))
{
//Ensures a non-username has been entered
if(empty($_POST['username']))
{
//we could find a better way to handle this in the future
die("Please enter a valid username.");
}
//Ensure that a non-empty password has been entered
if(empty($_POST['password']))
{
die("Please enter a password.");
}
//Ensures a valid email has been entered
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
        { 
            die("Invalid E-Mail Address"); 
        } 
//use sql queries to see if the username is taken
//a real value other than ':username' should be subbed in
$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
//this defines :username 
$query_params = array(
':username' => $_POST['username'] 
        ); 
try
{
//run queries against user table
$stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
//may not want to output this?
die("Failed to run query: " . $ex->getMessage()); 
} 
//fetch returns an array for the "next row from the selected results, or false if
//there is no rows to fetch
$row = $stmt->fetch();
//if a row was returned a matching user was found
if($row) 
        { 
            die("This username is already in use"); 
        } 
//now we check for to see if the email is already in use
//we do the exact same thing
$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
            die("This email address is already registered"); 
        } 
//an insert query is used to add new rows to the 'users' table
//using parameters
$query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt, 
                email 
            ) VALUES ( 
                :username, 
                :password, 
                :salt, 
                :email 
            ) 
        "; 
//we generate salts for each users password
$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
//hashes the passworded with the salt for secure storage
 $password = hash('sha256', $_POST['password'] . $salt);
//more hashing
for($round = 0; $round < 65536; $round++) 
        { 
            $password = hash('sha256', $password . $salt); 
        } 
//prepare our parameters mentioned above
$query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
            ':email' => $_POST['email'] 
        ); 
try
{
//executes the query to creat the user
	    $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
}
catch(PODException $ex)
{
//may not want to output this
die("Failed to run query: " . $ex->getMessage()); 
} 
//redirects the user to login page
header("Location: login.php"); 
//calling die here I'm pretty sure is really imporant
?>
<h1>Register</h1>
<form action="register.php" method="post">
Username:<br />
<input type="text" name="username" value="" />
<br /> <br />
E-mail:<br />
<input type="text" name="email" value="" />
<br /> <br />
Password:<br />
<input type="password" name="password" value="" />
<br /> <br />
<input type="submit" value="Register" />
</form>