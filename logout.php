<?php include "head.php"; ?>
<body>
    <?php 
        session_unset();
        session_destroy();
        header("location: loginPage.php");
    ?>
</body>
</html>