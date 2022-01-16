<?php
    include "head.php";
    require_once("dbaccess.php");
?>
<body>
<br><br>
    <?php 
    include "user_admin_check.php";
    include "nav.php"; //Ticket wird angezeigt
    if (isset($_GET["news_id"])){
        $sql = 'select content, headline, imgpath, date, time, active
                from news
                where news_id = ?';
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param('i', $_GET["news_id"]);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($content, $headline, $imgpath, $date, $time, $active);
        $stmt->fetch();
        $stmt->close(); //$db_obj->close();
        echo "<br><br><br><br><br><br><br><h2>". $headline. "</h2><br><h3>Last Updated:". $date. " ". $time .
        "</h3><br>";

        $_SESSION["news_id"] = $_GET["news_id"];
    }
    ?>
    <?php //News wird bearbeitet
        include "test_input.php"; //use test_input() to call function

         if (isset($_POST["content"])){
            $resolvInput = $_POST["resolved"];
            $ID = $_SESSION["ticketID"];
            $text_service = test_input($_POST["text_service"]);
            $sql = "update tickets 
                    set text_service = ?,
                    resolved = $resolvInput
                    where ticketID = $ID";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('s', $text_service);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            unset($_SESSION['ticketID']);
            header("Refresh:0; url=ticketVerwaltung.php");
         }
         if(isset($_POST["resolved"]) && $_SESSION["SessionWert"] == "Admin")
         {
            $resolvInput = $_POST["resolved"];
            $ID = $_SESSION["ticketID"];
            $sql = "update tickets 
                set resolved = $resolvInput
                where ticketID = $ID";
            $stmt = $db_obj->prepare($sql);
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            unset($_SESSION['ticketID']);
            header("Refresh:0; url=ticketVerwaltung.php");
         }
        ?>

    <form method="POST" action="ticketpage.php">
        <?php 
        if($_SESSION["SessionWert"] == "Admin"){ 
            if(isset($active) == 1){
                if(isset($content)){
                    echo "<textarea placeholder='news-content' required name='content'>".$content."</textarea>";
                }
                echo "<br><input name='active' type='radio' value=0 >Don't Display";
                echo "<br><input name='delete' type='checkbox'>Delete";
                echo "<br><input type='submit'>";
            }
            else{
                if(isset($content)){
                    echo "<textarea placeholder='news-content' required name='content'>".$content."</textarea>";
                }
                echo "<br><input name='active' type='radio' value=1 >Display"; 
                echo "<br><input name='delete' type='checkbox'>Delete";
                echo "<br><input type='submit'>";
                
            }
        }
        ?>
    </form>

</body>
</html>