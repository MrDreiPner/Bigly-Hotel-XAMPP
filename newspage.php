<?php
    include "head.php";
    require_once("dbaccess.php");
?>
<body>
<br><br><br>
    <?php 
    include "nav.php";
    include "user_admin_check.php";
    include "user_indicator.php";
    if (isset($_GET["newsID"])){
        $sql = 'select content, headline, imgpath, date, time, active
                from news
                where news_id = ?';
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param('i', $_GET["newsID"]);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($content, $headline, $imgpath, $date, $time, $active);
        $stmt->fetch();
        $stmt->close(); //$db_obj->close();
        echo "<br><br><br><br><br><br><br><div><h2>". $headline. "</h2><br><br><br><h3>Last Updated:". $date. " ". $time .
        "</h3><br><p>". $content . "</p></div>";

        $_SESSION["news_ID"] = $_GET["newsID"];
    }
    ?>
    <?php //News wird bearbeitet
        include "test_input.php"; //use test_input() to call function
        if(isset($_POST["delete"]))
        {
            $ID = $_SESSION["news_ID"];
            $sql = "delete 
                   from news 
                   where news_id = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_SESSION["news_ID"]);
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            unset($_SESSION['news_ID']);
            header("Refresh:0; url=newsVerwaltung.php");

        }

        if(isset($_POST["active"]))
        {
            if(isset($_POST["content"]) && isset($_POST["update_c"]))
            {
                $ID = $_SESSION["news_ID"];
                $resolvInput = $_POST["active"];
                $sql = "update news 
                        set active = $resolvInput,
                        content = ?
                        where news_id = $ID";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('s', $_POST["content"]);
            }
            else
            {
                $ID = $_SESSION["news_ID"];
                $resolvInput = $_POST["active"];
                $sql = "update news 
                        set active = $resolvInput
                        where news_id = $ID";
                $stmt = $db_obj->prepare($sql);
            }
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            unset($_SESSION['news_ID']);
            header("Refresh:0; url=newsVerwaltung.php");
         }
         else if(isset($_POST["update_c"]))
         {
            $ID = $_SESSION["news_ID"];
            $sql = "update news 
                    set content = ?
                    where news_id = $ID";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('s', $_POST["content"]);
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            unset($_SESSION['news_ID']);
            header("Refresh:0; url=newsVerwaltung.php");
         }
         else if(isset($_POST["sent"]))
         {
            setcookie("nothingHappened", 1, time()+5);
            header("Refresh:0; url=newsVerwaltung.php");
         }
        ?>

    <form method="POST" action="newspage.php">
        <?php 
        if($_SESSION["SessionWert"] == "Admin"){ 
            if(isset($active) && $active == 1){
                if(isset($content)){
                    echo "<textarea placeholder='news-content' required name='content'>".$content."</textarea>";
                }
                else
                {
                    echo "<textarea placeholder='news-content' required name='content'></textarea>";
                }
                echo "<br><input name='active' type='radio' value=0 >Don't Display";
                echo "<br><input name='update_c' type='checkbox' checked value='yes'>Update";
                echo "<br><input name='delete' type='checkbox' value='yes'>Delete";
                echo "<br><input type ='hidden' name ='sent' value = '1'/>";
                echo "<br><input type='submit'>";
            }
            else{
                if(isset($content)){
                    echo "<textarea placeholder='news-content' required name='content'>".$content."</textarea>";
                }
                else
                {
                    echo "<textarea placeholder='news-content' required name='content'></textarea>";
                }
                echo "<br><input name='active' type='radio' value=1 >Display"; 
                echo "<br><input name='update_c' type='checkbox' checked value='yes'>Update";
                echo "<br><input name='delete' type='checkbox' value='yes'>Delete";
                echo "<br><input type ='hidden' name ='sent' value = '1'/>";
                echo "<br><input type='submit'>";
            }
        }
        echo "<form action='newsVerwaltung.php'><input type='submit' value='Back'></form>";
        ?>
    </form>

</body>
</html>