<?php
    include "head.php";
    require_once("dbaccess.php");
?>
<body>
    <?php include "nav.php"; //Ticket wird angezeigt
    if (isset($_GET["ticketID"])){
        $sql = 'select text_guest, image_path, resolved, userID, Date, room, title 
                from tickets join user using(userID) 
                where status = true
                and ticketid = ?';
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param('i', $_GET["ticketID"]);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($text_guest, $image_path, $resolved, $userID, $date, $room, $title);
        $stmt->fetch();
        echo "<br><br><br><br><br><br><br><h2>". $title. "</h2><br><h3>". $date ."</h3><br>"
        . $text_guest . "<br><img src='". $image_path ."' alt ='". $room ."'>";
        $_SESSION["ticketID"] = $_GET["ticketID"];
    }
    ?>
    <?php //Ticket wird bearbeitet
         function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

         if (isset($_POST["text_service"])){
            if(isset($_POST["resolved"])){
                $resolved = 1;
                $status = 0;
            } else if(isset($_POST["status"])){
                $status = 0;
            } else {$status = 1;}
            $text_service = test_input($_POST["text_service"]);

            $sql = 'update tickets 
                    set text_service = ?,
                    resolved = ?,
                    status = ?
                    where ticketID = ?
                    ';
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('siii', $text_service, $resolved, $status,  $_SESSION["ticketID"]);
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
    ?>

    <form method="POST" action="ticketpage.php">
        <textarea placeholder="Service Response" required name="text_service"></textarea>
        <br><input type="checkbox" name="resolved">Issue Resolved
        <br><input type="checkbox"name="status">Close Ticket
        <br><input type="submit">Submit
    </form>

</body>
</html>