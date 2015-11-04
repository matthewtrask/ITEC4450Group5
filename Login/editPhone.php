<?php

//avoid error notices, display only warnings:
error_reporting(0);

//check if user submitted form:
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
	//connect to database:
	include('connection.php');
	include('navbar.php');
	echo "<br />";
	
	//Create an array for errors:
	$errors = array();
	
	//check for email address:
	if (empty($_POST['email'])){
		$errors[] = 'You forgot to enter your email!';
	}

	else{
$e = mysqli_real_escape_string($dbc, trim($_POST['email'])); //escape is to have input such as O’Hara; trim removes the space, return etc.
	}	
	
	//check current phone number:
	if (empty($_POST['phone'])){
		$errors[] = 'You forgot to enter your current phone number!';
	}

	else{
		$p = mysqli_real_escape_string($dbc, trim($_POST['phone']));
	}
	
	//check for a new password and compare it with confirmed password:
	if (!empty($_POST['newPhone'])){
		if ($_POST['newPhone'] != $_POST['newPhone1']){
			$errors[] = 'Your new phone number does not match the confirmed phone number!';
		}

		else{
			$np = mysqli_real_escape_string($dbc, trim($_POST['newPhone']));
		}
	}

	else{
		$errors[] = 'You forgot to enter your new phone number!';
	}

	//if there is no errors:
	if(empty($errors)){
		//create query and return number of rows where email = $e and password = $p:
		$q = "SELECT id FROM users WHERE (email='$e' AND phone='$p')"; //query the database
		$r = mysqli_query($dbc, $q); //store the query result which are all the IDs that matching the email
		$num = mysqli_num_rows($r); //return how many records matched; should be one
		
		//get user id where email = $e and password = $p:
		if($num == 1){
			$row = mysqli_fetch_array($r, MYSQLI_NUM);
				
			//Make the UPDATE query:
			$q = "UPDATE users SET phone='$np' WHERE id=$row[0]";
			$r = mysqli_query($dbc, $q);
			
			//if everything was ok:
			//if(mysqli_affected_rows($dbc) == 1){
				//Ok message confirmation:
				echo "Thanks! You have updated your phone number!";
			//}

//else{
				//echo "Your password could not be changed due to a system error";
			//}
			
			//close connection to db:
			mysqli_close($dbc);
		}

		else{
			echo "The email and phone number do not match our records!";
		}
	}

	else{
		echo "Error! The following error(s) occurred: <br />";
		foreach($errors as $msg){
			echo $msg."<br />";
		}
	} 
 
 }
