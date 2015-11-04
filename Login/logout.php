<?php 
//Log the user out and display a confirmation message
session_start();
session_destroy();

echo "<center>";


echo "<body>";
echo "<div>";

echo "<h2> You have succesfully logged out, hope to see you again soon! </h2>";
echo "<br /><a href = 'index.php'> Log in again? </a>";


echo "</div>";
echo "</body>";
echo "</center>";
?>