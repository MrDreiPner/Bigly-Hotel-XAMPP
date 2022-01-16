<?php include "head.php"; ?>
<body>
<br><br><br>
    <?php
        include "user_service_check.php";
        require_once ('dbaccess.php');
        include "nav.php";
        include "user_indicator.php";
    ?>
    <h1>Get to work you ungrateful git!</h1>
    <?php
        if(isset($_POST["filter"]) && $_POST["filter"] != "4"){
            $filter = $_POST["filter"];
            $orderby = $_POST["orderby"];
            $sql = "select ticketID, resolved, userID, Date, Time, username, nachname, room, title 
                    from tickets join user using(userID)
                    where resolved = $filter 
                    order by Date $orderby";
            $stmt = $db_obj->prepare($sql);
            //$stmt->bind_param('ss', $_POST["filter"], $_POST["orderby"]);
        } else {
            $orderby = "asc";
            if(isset($_POST["orderby"])){
                $orderby = $_POST["orderby"];
            }
            $sql = "select ticketID, resolved, userID, Date, Time, username, nachname, room, title 
                    from tickets join user using(userID)
                    order by Date $orderby";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($ticketid, $resolved, $userID, $date, $time, $username, $nachname, $room, $title);
    
    ?>
    <br><br><br><br><br><br><br>
    <div class="input">
    <table id="table">
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
    </div>
    <div>
        <form name="filters" method="POST" action="ticketVerwaltung.php">
            <label for="filter">Filter by:</label>
            <select name="filter">
                <option value=4>No Filter</option>
                <option value=1>open</option>
                <option value=2>resolved</option>
                <option value=3>unresolved</option>
            </select>
            <br>
            <label for="orderby">Order by Date:</label>
            <select name="orderby">
                <option value="asc">ascending</option>
                <option value="desc">descending</option>
            </select>
            <input type="submit">
        </form>
    </div>
    
</body>
</html>