<?php include ("../head.php"); ?>
    <body>
        <?php
            include ("../nav.php");
            require_once ('../dbaccess.php');
        ?>
        <div id="header">
            <h1>Welcome to BIGLY HOTEL</h1>
        </div>
        <p>
            <?php
            if (isset($_COOKIE["inactiveLogout"])){
                echo "<br><h3>You have been logged out due to inactivity!</h3>";
            }
            ?>
        </p>
        <div>
            <h3>News Feed</h3>
        </div>
        <br>
        <?php include ("../news/printNews.php"); ?>
    </body>
</html>