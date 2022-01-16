<?php include "head.php"; ?>
<body>
<br><br><br>
    <?php
        include "nav.php";
        include "user_indicator.php";
        require_once ('dbaccess.php');
    ?>
    <div id="Header">
        <h1>BIGLY HOTEL</h1>
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
    <?php include "printNews.php"; ?>
</body>
</html>