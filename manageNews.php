<?php include "head.php"; ?>
<body>
<br><br><br>
    <?php
        require_once('dbaccess.php');
        include "nav.php";
        include "user_admin_check.php";
        include "user_indicator.php";

        /*$sql = "select headline, date, time, active, news_id 
                    from news
                    order by date asc";
            $stmt = $db_obj->prepare($sql);*/
        if(isset($_POST["filter"]) && $_POST["filter"] != "4"){
            $filter = $_POST["filter"];
            $orderby = $_POST["orderby"];
            $sql = "select headline, date, time, active, news_id  
                    from news
                    where active = $filter 
                    order by Date $orderby";
            $stmt = $db_obj->prepare($sql);
            //$stmt->bind_param('ss', $_POST["filter"], $_POST["orderby"]);
        } else {
            $orderby = "asc";
            if(isset($_POST["orderby"])){
            $orderby = $_POST["orderby"];
            }
            $sql = "select headline, date, time, active, news_id  
                    from news
                    order by Date $orderby";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $date, $time, $active, $id);
    ?>
    <div>
        <form name="filters" method="POST" action="manageNews.php">
            <label for="filter">Filter by:</label>
            <select name="filter">
                <option value=1>active</option>
                <option value=0>inactive</option>
            </select>
            <br>
            <label for="orderby">Order by Date:</label>
            <select name="orderby">
                <option value="asc">ascending</option>
                <option value="desc">descending</option>
            </select>
            <input type="submit">
        </form>
        <?php
            if(isset($_COOKIE["nothingHappened"]))
            {
                echo "No changes!";
            }
        ?>
    </div>
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