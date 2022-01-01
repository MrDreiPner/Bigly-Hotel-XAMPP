<?php include "head.php"; ?>
<body id="ua_access">
    <h1>
        ERROR 401<br>
        Unauthorized access!
    </h1>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <h2>
        You will be redirected to the homepage soon!<br>
        If you are not redirected in 6 seconds - <a href="index.php">Click here!</a>
    </h2>
<?php
    header("Refresh: 5; url = index.php");
?>
</body>
</html>