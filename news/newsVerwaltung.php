<?php include ("../head.php"); ?>
<body>
<br><br><br>
    <?php
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_admin_check.php");

        //printet gefilterte, sortierte Liste der News Posts
        if(isset($_POST["filter"]) && $_POST["filter"] != "2"){
            $filter = $_POST["filter"];
            $orderby = $_POST["orderby"];
            $sql = "select headline, date, time, active, news_id  
                    from news
                    where active = $filter 
                    order by Date $orderby, time $orderby";
            $stmt = $db_obj->prepare($sql);
        } else {
            $orderby = "desc";
            if(isset($_POST["orderby"])){
            $orderby = $_POST["orderby"];
            }
            $sql = "select headline, date, time, active, news_id  
                    from news
                    order by Date $orderby, time $orderby";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $date, $time, $active, $id);
    ?><div><br><br><br>
    <div id="table-sort">
        <h3>News List</h3><br> <!--Filtermöglichkeit nach active state-->
        <form name="filters" id="filter" method="POST" action="newsVerwaltung.php">
            <div>
                <label for="filter">Filter by:</label>
                <select  name="filter" class="form-select-sm form-select">
                    <option value=2>No Filter</option>
                    <option value=1>active</option>
                    <option value=0>inactive</option>
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
            <a class='btn btn-primary' id="addNews-button" href='addNews.php'>Post News</a>
        </form>
        
        <?php
            if(isset($_COOKIE["nothingHappened"]))
            {
                echo "No changes!";
            }
        ?>
    </div>

        <table id="table" class="table table-striped table-hover">
        <tr>
            <th>Active</th>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
        <?php //printet eine Liste aller News Posts
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