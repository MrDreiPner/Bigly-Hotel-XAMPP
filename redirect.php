
<?php 
echo "<h2>You have been logged out due to inactivity</h2>";
setcookie("inactiveLogout", 1, time()+1);
header("location: index.php");
?>