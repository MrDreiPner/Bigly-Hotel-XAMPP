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
    <?php
        //fetched die active gesetzten News aus der Datenbank
        $sql = 'select headline, imgpath, content, date from news 
                where active = true
                order by date desc';
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
            //Printet die News Beiträge
            while($stmt->fetch()){
                echo "<li><p><h4>". $headline. "</h4>". $date ."<br>"
                 . $content . "<br><img src='". $imgpath ."' alt ='". $headline ."'>
                 </p>
                </li>";
            }
            $stmt->close(); $db_obj->close();
        ?>
    </ul>
</body>
</html>