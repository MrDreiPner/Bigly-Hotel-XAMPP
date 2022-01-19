<?php
    include ("../head.php");
?>
<body>
    <?php include ("../nav.php"); ?>

    <?php 
        require_once('../dbaccess.php');
        include ("../checks/user_logged_check.php");
        include ("../checks/test_input.php");//test_input() nutzen um rohe Daten zu testen, für mehr siehe test_input.php
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
            $stmt->close();
            echo "<div class='ticket-card'>
                    <div id='inner-form2'>";
            echo "<img class='img-fluid rounded-start' src='". $image_path ."' alt ='Room: ". $room ."'>
                        <h4 class='card-title'>". $title. "</h4>
                        <p class='card-text'><small class='text-muted'>". $date. " ". $time ." "."Room: ".$room ."</small></p>
                        <p class='card-text'>". $text_guest."</p>";
            echo "<div><p class='card-text'>Service Response:<br>".$textS. "</p>
                        </div>
                    </div>
                </div>";

            $_SESSION["ticketID"] = $_GET["ticketID"];
        }
    ?>
    <?php //Ticket wird bearbeitet
        
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
         if(isset($_POST["resolved"]) && $_SESSION["SessionWert"] != "Service")
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
    <div class="ticket-card">
        <div id='inner-form'>
            <form method="POST" action="ticketpage.php">
                <?php 
                if($_SESSION["SessionWert"] == "Service" && isset($resolved)){ 
                    if($resolved == "open"){
                        echo "<textarea class='form-control' placeholder='Service Response' required name='text_service'>".$textS."</textarea>";
                        echo "<br><input class='form-check-input' name='resolved' type='radio' value=2 checked>
                            <label class='form-check-label' for='resolved'>Issue resolved</label>";
                        echo "<input class='form-check-input' name='resolved' type='radio' value=3>
                            <label class='form-check-label' for='resolved'>Issue unresolved</label>"; 
                        echo "<br><input type='submit' id='submit' class='btn btn-primary' value='Reply'>";
                    }
                    else{
                        echo "Ticket closed! Ticket ". $resolved; 
                    }
                }
                if(($_SESSION["SessionWert"] == "Admin" || $_SESSION["SessionWert"] == "Guest") && isset($resolved)){ 
                    if($resolved != "open"){
                        echo "<br><input type='checkbox'name='resolved' value=1>Open Ticket"; 
                        echo "<br><input type='submit' id='submit' class='btn btn-primary' value='Submit'> ";
                    }
                    else{
                        echo "Ticket open!"; 
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>