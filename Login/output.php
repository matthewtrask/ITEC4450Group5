<?php
	include("connection.php");
	$r = mysqli_query($dbc, "SELECT * FROM users");
	
	
mysqli_close($dbc); //always close the connection for security
echo "database connection closed."; //this echo is for testing stage only, no need to show it to user. 


echo "<table>
    <tr>
        <td align='left'><b>Edit</b></td>
        <td align='left'><b>Delete</b></td>
        <td align='left'><b>Name</b></td>
        <td align='left'><b>Email</b></td>
        <td align='left'><b>Delete User By Id</b></td>
    </tr>";
//use while loop to display results 
while ($row = mysqli_fetch_array($r)){
    
    echo "<tr>
			<td align='left'><a href='edit_new.php?user_id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."'>Edit </a></td>
			<td align='left'><a href='remove_form.php?user_id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."'>Delete</a></td>
			<td align='left'>".$row['first_name']."/".$row['email']."</td>
            <td align='left'>".$row['last_name'].", ".$row['first_name']."</td>
            <td align='left'>".$row['email']."</td>
			<td align='left'><a href='remove_form.php?user_id=".$row['id']."&fname=".$row['first_name']."&lname=".$row['last_name']."'>".$row['id']." </a></td>
        </tr>";
}
echo "</table>";
?>