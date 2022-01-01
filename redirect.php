
<?php 
    setcookie("inactiveLogout", 1, time()+1);
    header("Refresh:0; url=index.php");
?>