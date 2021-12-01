<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <div id="Header">
        <h1>BIGLY HOTEL</h1>
    </div>
    <p>
        <?php
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ", $_COOKIE["CookieWert"];
        }
        ?>
        <br>
        <a href="registrierung.php">Hier registrieren/ anmelden</a><br>
        <a href="service.php">Service</a><br>
        <h1><a href="https://www.youtube.com/watch?v=FfKWHtNDGKU" target="_blank">Quality content</a></h1>
    </p>
    <img src="WIP.jpg" alt="Work in Progress">
    <br>
    <?php include "werbebanner.php";?>
</body>
</html>