<?php 
    include ("head.php");
    session_unset();
    session_destroy();
    echo "<h3>You have been logged out successfully! Wow! :3</h3>";
    header("Refresh:1; url=loginPage.php");
?>
</html>