<?php include "head.php"; ?>
<body>
    <?php include "nav.php"; ?>
    <br><br><br>
    <?php 
        session_unset();
        session_destroy();
        echo "<h1> You gone now! </h1>";

        header("location: loginPage.php");
    ?>
</body>
</html>