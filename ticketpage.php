<?php
    include "head.php";
?>
<body>
<br><br><br>
    <?php 
        require_once("dbaccess.php");
        include "user_logged_check.php";
        include "nav.php"; //Ticket wird angezeigt
        include "user_indicator.php";
        if (isset($_GET["ticketID"])){
            $sql = 'select text_guest, image_path, resolved, userID, Date, Time, room, title, text_service 
                    from tickets join user using(userID) 
                    where ticketid = ?';
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_GET["ticketID"]);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->bind_result($text_guest, $image_path, $resolved, $userID, $date, $time, $room, $title, $textS);
            $stmt->fetch();
            $stmt->close(); //$db_obj->close();
            echo "<br><br><br><br><br><br><br><h3>". $title. "</h3><br><h4>". $date. " ". $time .
            " "."Room: ".$room ."</h4><br>". $text_guest;
            echo "<br><img src='". $image_path ."' alt ='Room: ". $room ."'>";
            echo "<br><div>Service Response:<br>".$textS. "</div>";

            $_SESSION["ticketID"] = $_GET["ticketID"];
        }
    ?>
    <?php //Ticket wird bearbeitet
        include "test_input.php"; //test_input() nutzen um rohe Daten, für mehr siehe test_input.php

         if (isset($_POST["text_service"])){
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
         if(isset($_POST["resolved"]))
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
            if($_SESSION["SessionWert"] == "Admin")
            {
                header("Refresh:0; url=ticketVerwaltung.php");
            }
            else
            {
                header("Refresh:0; url=service.php");
            }
         }
        ?>

    <form method="POST" action="ticketpage.php">
        <?php 
        if(/*$_SESSION["SessionWert"] == "Admin" ||*/ $_SESSION["SessionWert"] == "Service"){ 
        if($resolved == "open")
        {
            echo "<textarea placeholder='Service Response' required name='text_service'>".$textS."</textarea>";
            echo "<br><input name='resolved' type='radio' value=2 checked>Issue resolved";
            echo "<input name='resolved' type='radio' value=3>Issue unresolved"; 
            echo "<br><input type='submit' value='Reply'>";
        }
        else{
            echo "Ticket closed! Ticket ". $resolved; 
        }
        }
        if($_SESSION["SessionWert"] == "Admin" || $_SESSION["SessionWert"] == "Guest")
        { 
        if($resolved != "open")
        {
            echo "<br><input type='checkbox'name='resolved' value=1>Open Ticket"; 
            echo "<br><input type='submit' value='Submit'> ";
        }
        else{
                echo "Ticket open!"; 
            }
        }
        ?>
    </form>
    <?php
    if($_SESSION["SessionWert"] == "Admin" || $_SESSION["SessionWert"] == "Service")
    {
        echo "<form action='ticketVerwaltung.php'><input type='submit' value='Back'></form>";
    }
    else
    {
        echo "<form action='service.php'><input type='submit' value='Back'></form>";
    }
    ?>
</body>
</html>