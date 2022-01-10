<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
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
        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ". $_SESSION["SessionWert"];
        }
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ". $_COOKIE["CookieWert"];
        }
        ?>
        <br>
        <h1><a href="https://www.youtube.com/watch?v=FfKWHtNDGKU" target="_blank">Quality content</a></h1>
        <a href="UA_access.php"> 401 error page </a>
    </p>
    <!--<img src="Werbebilder/harold1.jpg" alt="Work in Progress">-->
    <br>
    <?php
        $sql = 'select headline, imgpath, content, date from news where active = true';
        $stmt = $db_obj->prepare($sql);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $imgpath, $content, $date);
    ?>
    <ul>
        <?php 
            while($stmt->fetch()){
                echo "<li><p><h3>". $headline. "</h3>". $date ."<br>"
                 . $content . "<img src='". $imgpath ."' alt ='". $headline ."'>
                 </p>
                </li>";
            }
            $stmt->close(); $db_obj->close();
        ?>
    </ul>
</body>
</html>