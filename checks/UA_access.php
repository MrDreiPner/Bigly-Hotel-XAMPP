<?php include ("../head.php"); //Link auf UA Seite falls, jemand ungültigen Zugang hat ?>
<body id="ua_access"> 
    <h1>
        ERROR 401<br>
        Unauthorized access!
    </h1>
    <br><br><br>
    <h2>
        You will be redirected to the homepage soon!<br>
        If you are not redirected in 6 seconds - <a href="../main/index.php">Click here!</a>
    </h2>
<?php
    header("Refresh: 5; url = ../main/index.php");
?>
</body>
</html>