<?php
error_reporting(0);
include("connection.php");
//grab values email and password from login form
$login_email = $_POST['login_email']; //match with the name in the login form
$login_password = $_POST['login_password'];
//create the query and number of rows returned from the query
$query = mysqli_query($dbc, "SELECT * FROM users WHERE email='".$login_email."'");
$numrows = mysqli_num_rows($query);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
//create condition to check if there is 1 row with that email
if($numrows != 0){
//grab the email and password from that row returned before
	while($row = mysqli_fetch_array($query)){
	
		$dbemail = $row['email']; //must matching with the field name in your database table;
		$dbpass = $row['pw'];
		$dbfirstname = $row['first_name'];		
		}	
//create condition to check if email and password are equal to the returned row	
	
	if($login_email==$dbemail){
		if($login_password==$dbpass){
		
			echo "Welcome ".$dbfirstname.", you are in the wonderland!";
			include ("navbar.php");
		
		}else{		
			echo "your password is incorrect!";
		
		}
	}else{
	
		echo "your email is incorrect!";
	
	}
	
}else{

echo "Invalid credentials! If you are not registered please register <a href='userform.php'>below</a>...";

}
}else{

	echo "Please Login...";

}
?>
