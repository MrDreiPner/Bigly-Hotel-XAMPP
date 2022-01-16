<?php include "head.php"; ?>
<body>
    <?php
        require_once('dbaccess.php');
        include "nav.php";
        include "user_admin_check.php";

        $sql = "select headline, date, time, active, news_id 
                    from news
                    order by date asc";
            $stmt = $db_obj->prepare($sql);
        
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $date, $time, $active, $id);
    ?>
    <br><br><br>
        <table id="table">
        <tr>
            <th>Active</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php
            while($stmt->fetch()){
                echo "<tr>";
                if($active == 1){echo "<td>Yes</td>";} else {echo "<td>No</td>";}
                echo "<td><a href='newspage.php?newsID=" . $id ."'>" .$headline."</a></td>
                <td>". $date."</td>
                <td>". $time."</td>
                </tr>";
            }
            $stmt->close(); $db_obj->close();
        ?>
        </table>
</body>
</html>