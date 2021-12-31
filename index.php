<?php include "head.php"; ?>
<body>
    <?php
    //DB connection needed
        include "nav.php";
    ?>
    <div id="Header">
        <h1>BIGLY HOTEL</h1>
    </div>
    <p>
        <?php
        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ". $_SESSION["SessionWert"];
        }
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ". $_COOKIE["CookieWert"];
        }
        ?>
        <br>
        <h1><a href="https://www.youtube.com/watch?v=FfKWHtNDGKU" target="_blank">Quality content</a></h1>
    </p>
    <img src="Werbebilder/harold1.jpg" alt="Work in Progress">
    <br>
    <?php include "werbebanner.php";?>
</body>
</html>