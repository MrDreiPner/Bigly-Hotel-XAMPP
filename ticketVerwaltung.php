<?php include "head.php"; ?>
<body>
    <?php
        include "user_service_check.php";
        require_once ('dbaccess.php');
        include "nav.php";
    ?>
    <h1>Get to work you ungrateful git!</h1>
    <?php
        $sql = 'select ticketID, resolved, userID, Date, room, title 
                from tickets join user using(userID) 
                where status = true';
        $stmt = $db_obj->prepare($sql);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($ticketid, $resolved, $userID, $date, $room, $title);
    ?>
    <br><br><br><br><br><br><br>
    <table>
        <tr>
            <th>Resolved</th>
            <th>Title</th>
            <th>Date</th>
            <th>Room</th>
        </tr>
        <?php 
            while($stmt->fetch()){
                echo "<tr>
                <td>". $resolved.
                "</td><td><a href='ticketpage.php?ticketID=" . $ticketid ."'>" .$title.
                "</a></td><td>". $date .
                "</td><td>". $room."
                </td></tr>";
            }
            $stmt->close(); $db_obj->close();
        ?>
    </table>
    
</body>
</html>