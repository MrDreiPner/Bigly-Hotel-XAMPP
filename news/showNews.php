<?php include ("../head.php"); ?>
<body>
<?php
    include ("../nav.php");
    include ("../checks/user_indicator.php");
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
        echo "<div class='row g-0' id='news-card news-center'>
        <div class='col-md-4'>
            <img src='".$imgpath."' class='img-fluid rounded-start' alt='".$headline."'>
            </div>
            <div class='col-md-8'>
                <div class='card-body' id='news-text'>
                    <h4 class='card-title'>".$headline."</h4>
                    <p>".$content."</p>
                    ".$date."
                </div>
            </div>
        </div>";
        $stmt->close(); $db_obj->close();
    }
    else
    {
        header("location: UA_access.php");
    }
?>
<form action='../main/index.php'><input type='submit' value='Back'></form>
</body>
</html>