<?php include "head.php"; ?>
<body>
<?php
    if(isset($_GET["news_id"]))
    {
        //selektiert die active gesetzten News aus der Datenbank
        $news_id = $_GET["news_id"];
        $sql = 'select headline, imgpath, content, date
                from news 
                where active = true
                and news_id = ?
                order by date desc, time desc';
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param('i', $news_id);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $imgpath, $content, $date);
        echo "<p><h4>". $headline. "</h4>". $date ."<br>"
        . $content . 
        "<br><div id='image'><img src='". $imgpath ."' alt ='". $headline ."'></div>
        </p>";
    }
    else
    {
        header("location: UA_access.php");
    }
    ?>
</body>
</html>