<?php include "head.php"; ?>
<body>
    <?php
        include "user_service_check.php";
        require_once ('dbaccess.php');
       // include "nav.php";
    ?>
    <h1>Get to work you ungrateful git!</h1>
    <?php
        if(isset($_POST["filter"])){
            var_dump($_POST["filter"]);
            var_dump($_POST["orderby"]);
            $sql = 'select ticketID, resolved, userID, Date, Time, room, title 
                    from tickets join user using(userID)
                    where resolved = ?
                    order by Date ?';
            $stmt = $db_obj->prepare($sql);
            
            $stmt->bind_param('ss', $_POST["filter"], $_POST["orderby"]);
        } else {
            $sql = 'select ticketID, resolved, userID, Date, Time, room, title 
                    from tickets join user using(userID)
                    order by Date asc';
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($ticketid, $resolved, $userID, $date, $time, $room, $title);
    
    ?>
    <br><br><br><br><br><br><br>
    <div class="input">
    <table id="table">
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
    <div>
        <form name="filters" method="POST" action="ticketVerwaltung.php">
            <label for="filter">Filter by:</label>
            <select name="filter">
                <option value="1">open</option>
                <option value="2">resolved</option>
                <option value="3">unresolved</option>
                <option>No Filter</option>
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