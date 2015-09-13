
<?php
//define the connection information for MySQL database
    $username = "dbusername"; 
    $password = "dbpassword"; 
    $host = "localhost"; 
    $dbname = "dbname"; 
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
try 
    { 
//This should open a connection to your database using the PDO library.
	$db = new PDO("mysql:host={$host};
	dbname={$dbname};charset=utf8", $username, $password, $options); 
    }
catch(PDOException $ex)
{
//errors should be trapped here, I hope.
//The script should output an error and stop
 die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
//this statement configures POD to throw an exception so we can
//use try catch to trap database errors
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
//returns database rows
 $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//this is supposed to undue magic quotes I don't know what that means but
//it looks like I'm supposed to include it. 
if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
//tells browser you're using UTF-8 encoding
header('Content-Type: text/html; charset=utf-8');
//initializes your session
 session_start();
//I don't think you're supposed to use an end tag but I could be wrong about that. 