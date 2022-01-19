<?php include ("../head.php"); ?>
<body>

    <?php 
        include ("../checks/user_guest_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_indicator.php");
        include ("../checks/test_input.php");//test_input() nutzen um rohe Daten zu testen, für mehr siehe test_input.php
    ?>
    <div id="form">
        <div id="inner-form-service">
            <h1 id="Überschrift">File new Ticket</h1><br>
            <form enctype="multipart/form-data" method="POST">
            <div class="mb-3">        
                <label for="Betreff" class="form-label">Betreff</label><br>
                <span class="error"> <?php if(isset($errors)){ echo $errors;}?></span>
                <input type="text" class="form-control" required name="Betreff"><br>
            </div>
            <div class="mb-3">
                <label for="serviceText" class="form-label">Please describe the issue</label>
                <textarea name="serviceText" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <span class="error"><?php if(isset($error)){ echo $error;}?></span>
                <input type="file"  id="img-upload" class="btn btn-primary btn-sm form-control" accept=".jpg, .png"  name="Bildupload">
            </div>
        <input type="submit" id="submit" value="Submit" class="btn btn-primary">
    </form>
    </div>
    <?php 
        include ("../resizeImage.php");
        
        $bildname = "";
        $errors = "";
        $error = "";
        if (isset($_POST["Betreff"])){
            $errors = checkOnlyCharsAndNumbers($_POST["Betreff"]);
            $betreff = test_input($_POST["Betreff"]);
        }

        if (isset($_FILES["Bildupload"]["name"]) && $_FILES["Bildupload"]["name"] != ""){ //checkt Bildupload und lädt resized image auf die Datenbank
            $bildname = test_input($_FILES["Bildupload"]["name"])."_".uniqid();
            $errors = checkOnlyCharsAndNumbersNoSpace($_FILES["Bildupload"]["name"]);
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            $destimage = "../uploads/service/".$bildname."-thumb";
            switch($path_parts["extension"]){
                case "jpg" : 
                    $destimage = "../uploads/service/".$bildname."-thumb.jpg"; 
                    $destimage = resizeJpeg($bildname, $destimage); 
                    break;
                case "png" : 
                    $destimage = "../uploads/service/".$bildname."-thumb.png"; 
                    $destimage = resizePng($bildname, $destimage); 
                    break;
                default: $error = "Bitte nur JPG oder PNG Files!!!!!";
            }
        }
        
        if (isset($_POST["serviceText"]) && $error == ""){
            $serviceText = test_input($_POST["serviceText"]);
            $u_username = $_SESSION["ID"];
            $sql = "INSERT INTO tickets (title, text_guest, image_path, userID, resolved) VALUES (?, ?, ?, ?, 1)";
            $stmt = $db_obj->prepare($sql);
            if ($stmt===false){
                echo($db_obj->error);
            }
            $stmt->bind_param("sssi",$betreff, $serviceText, $destimage, $u_username);
            $stmt->execute();
        }
        
        //Hier wird nach diversen Kriterien gefiltert wobei 4 "No Filter" bedeutet
        if(isset($_POST["filter"]) && $_POST["filter"] != "4"){
            $filter = $_POST["filter"];
            $orderby = $_POST["orderby"];
            $userID = $_SESSION["ID"];
            $sql = "select ticketID, resolved, userID, Date, Time, room, title 
                    from tickets join user using(userID)
                    where resolved = $filter and userID = $userID
                    order by Date $orderby, time $orderby";
            $stmt = $db_obj->prepare($sql);
        } else {
            $userID = $_SESSION["ID"];
            $orderby = "desc";
            if(isset($_POST["orderby"])){
                $orderby = $_POST["orderby"];
            }
            $sql = "select ticketID, resolved, userID, Date, Time, room, title 
                    from tickets join user using(userID)
                    where userID = $userID
                    order by Date $orderby, time $orderby";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($ticketid, $resolved, $userID, $date, $time, $room, $title);
    
    ?>
    <div id="table-sort">
        <h3>Your Service-Tickets</h3><br>
        <div id="option-select">
            <form name="filters" id="filter-box" method="POST" action="service.php">
                <div>
                    <label for="filter">Filter by:</label>
                    <select name="filter" class="form-select-sm form-select">
                        <option value=4>No Filter</option>
                        <option value=1>open</option>
                        <option value=2>resolved</option>
                        <option value=3>unresolved</option>
                    </select>
                </div>
                <div>
                    <label for="orderby">Order by Date:</label>
                    <select name="orderby" class="form-select-sm form-select">
                        <option value="asc">ascending</option>
                        <option value="desc">descending</option>
                    </select>
                </div>
                <input type="submit" id="filter-submit" class="btn btn-primary">
            </form>
            <?php
                if($_SESSION["SessionWert"] != "Guest")
                {
                    echo "<form name='filters' id='filter-box' action='ticketVerwaltung.php'><input type='submit' value='Back'></form>";
                }
                else
                {
                    echo "<form name='filters' id='filter-box' action='../main/index.php'><input type='submit' value='Back'></form>";
                }
                ?>
        </div>
        <div>
            <table id="table" class="table table-striped table-hover">
                <tr>
                    <th>Resolved</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Room</th>
                </tr>
                <?php 
                    while($stmt->fetch()){
                        echo "<tr>
                        <td>". $resolved.
                        "</td><td><a href='ticketpage.php?ticketID=" . $ticketid ."'>" .$title.
                        "</a></td><td>". $date.
                        "</td><td>". $time.
                        "</td><td>". $room.
                        "</td></tr>";
                    }
                    $stmt->close(); $db_obj->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>