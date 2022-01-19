<?php include ("../head.php"); ?>
<body>
<?php
    include ("../nav.php");
    require_once('../dbaccess.php');
    if(isset($_GET["news_id"]))
    {
        //selektiert die active gesetzten News aus der Datenbank
        $news_id = $_GET["news_id"];
        $sql = "select headline, imgpath, content, date
                from news 
                where active = true
                and news_id = '$news_id'";
        $stmt = $db_obj->prepare($sql);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $imgpath, $content, $date);
        $stmt->fetch();
        echo "<div id='news-card news-center'>
            <img src='".$imgpath."' id='harold' class='img-fluid rounded-start' alt='".$headline."'>
            </div>
            <div>
                <div class='card-body center' id='inner-form2'>
                    <h4 class='card-title'>".$headline."</h4>
                    <p>".$content."</p>
                    <p class='card-text'><small class='text-muted'>".$date."</small></p>
                </div>
                </div>";
        $stmt->close(); $db_obj->close();
    }
    else
    {
        header("location: ../checks/UA_access.php");
    }
?>
</body>
</html>