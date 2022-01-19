<?php include ("../head.php"); ?>
<body>
    <?php
        include ("../checks/user_service_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
    ?>
    <?php //Selektieren , sortieren mit Filter
        if(isset($_POST["filter"]) && $_POST["filter"] != "4"){
            $filter = $_POST["filter"];
            $orderby = $_POST["orderby"];
            $sql = "select ticketID, resolved, userID, Date, Time, username, nachname, room, title 
                    from tickets join user using(userID)
                    where resolved = $filter 
                    order by Date $orderby, Time $orderby";
            $stmt = $db_obj->prepare($sql);
        } else { //Selektieren mit Sortierung
            $orderby = "desc";
            if(isset($_POST["orderby"])){
                $orderby = $_POST["orderby"];
            }
            $sql = "select ticketID, resolved, userID, Date, Time, username, nachname, room, title 
                    from tickets join user using(userID)
                    order by Date $orderby, time $orderby";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($ticketid, $resolved, $userID, $date, $time, $username, $nachname, $room, $title); 
    ?> <div><br><br><br>
        <div id="table-sort">
            <h3>Ticket List</h3><br>
            <form name="filters" id="filter" method="POST" action="ticketVerwaltung.php">
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
                <?php  if($_SESSION["SessionWert"] == "Admin"){
                            echo "<a class='btn btn-primary' id='addNews-button' href='service.php'>Open Service Ticket</a>";
                }  ?>
            </form>
        </div> 
        <table id="table" class="table table-striped table-hover">
            <tr>
                <th>Resolved</th>
                <th>Username</th>
                <th>Title</th>
                <th>Nachname</th>
                <th>Date</th>
                <th>Time</th>
                <th>Room</th>
            </tr>
        <?php 
            while($stmt->fetch()){
                echo "<tr>
                <td>". $resolved.
                "</td><td>".$username.
                "</td><td><a href='ticketpage.php?ticketID=" . $ticketid ."'>" .$title.
                "</a></td><td>". $nachname.
                "</td><td>". $date.
                "</td><td>". $time.
                "</td><td>". $room.
                "</td></tr>";
            }
            $stmt->close(); $db_obj->close();
        ?>
        </table>  
</body>
</html>