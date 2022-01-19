<?php include ("../head.php"); ?>
<body>
<br><br><br>
    <?php
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_admin_check.php");
    //Select Statements für alle Sortier und Filteroptionen
        //Filtern nach Aktivität und Rolle & sortieren 
        if(isset($_POST["filterActive"]) && $_POST["filterActive"] != 2 && $_POST["filterRole"] != 0){
            $filterActive = $_POST["filterActive"];
            $filterRole = $_POST["filterRole"];
            $orderGroup = $_POST["orderGroup"];
            $orderby = $_POST["orderby"];
            $sql = "select username, anrede, vorname, nachname, room, active, role, userID  
                    from user
                    where active = $filterActive AND role = $filterRole 
                    order by $orderGroup $orderby";
            $stmt = $db_obj->prepare($sql);
        //Filtern nach Aktivität & sortieren
        } elseif(isset($_POST["filterActive"]) && $_POST["filterRole"] == 0 && $_POST["filterActive"] != 2) {
            $filterActive = $_POST["filterActive"];
            $orderGroup = $_POST["orderGroup"];
            $orderby = $_POST["orderby"];
            $sql = "select username, anrede, vorname, nachname, room, active, role, userID  
                    from user
                    where active = $filterActive
                    order by $orderGroup $orderby";  
            $stmt = $db_obj->prepare($sql);  
        //Filtern nach Rolle & sortieren
        } elseif(isset($_POST["filterRole"]) && $_POST["filterActive"] == 2 && $_POST["filterRole"] != 0){
            $filterRole = $_POST["filterRole"];
            $orderGroup = $_POST["orderGroup"];
            $orderby = $_POST["orderby"];
            $sql = "select username, anrede, vorname, nachname, room, active, role, userID  
                    from user
                    where role = $filterRole
                    order by $orderGroup $orderby";
            $stmt = $db_obj->prepare($sql);
        //Nur sortieren
        } elseif(isset($_POST["filterActive"]) && $_POST["filterActive"] == 2 && $_POST["filterRole"] == 0){
            $orderGroup = $_POST["orderGroup"];
            $orderby = $_POST["orderby"];
            $sql = "select username, anrede, vorname, nachname, room, active, role, userID  
                    from user order by $orderGroup $orderby";
            $stmt = $db_obj->prepare($sql);
        }else{
            $sql = "select username, anrede, vorname, nachname, room, active, role, userID  
                    from user order by active desc";
            $stmt = $db_obj->prepare($sql);
        }
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($username, $anrede, $vorname, $nachname, $room, $active, $role, $userID);
    ?>
    <div><br><br><br>

    <!--Filter- & Sortieroptionen für Userliste
        Filtern möglich nach Aktiv/Inaktiv und/oder User Rolle
        Sortieren möglich nach Username, Vorname, Nachname, Anrede, Zimmer, Aktiv, Rolle
    -->
    <div id="table-sort">
        <h3>User List</h3><br>
         <form name="filters" id="filter" method="POST" action="userVerwaltung.php">
             <div>
                <label for="filterActive">Filter by:</label>
                <select name="filterActive" class="form-select-sm form-select">
                    <option value=2>No Filter</option>
                    <option value=1>active</option>
                    <option value=0>inactive</option>
                </select>
            </div>
            <div>
                <label for="filterRole">Filter by:</label>
                <select name="filterRole" class="form-select-sm form-select">
                    <option value=0>No Filter</option>
                    <option value=1>Admin</option>
                    <option value=2>Service</option>
                    <option value=3>Guest</option>
                </select>
            </div>
            <div>
                <label for="orderby">Order by:</label>
                <select name="orderGroup" class="form-select-sm form-select">
                    <option value="active">Active</option>
                    <option value="role">Role</option>
                    <option value="username">Username</option>
                    <option value="anrede">Gender</option>
                    <option value="vorname">First Name</option>
                    <option value="nachname">Last Name</option>
                    <option value="room">Room</option>
                </select>
            </div>
            <div>
                <label for="orderby">Order by:</label>
                <select name="orderby" class="form-select-sm form-select">
                    <option value="asc">ascending</option>
                    <option value="desc">descending</option>
                </select>
            </div>
            <input type="submit" id="filter-submit" class="btn btn-primary">
            <a class='btn btn-primary' id="addNews-button" href='registrierung.php'>Register New User</a>
        </form>

        <?php
            if(isset($_COOKIE["nothingHappened"]))
            {
                echo "No changes!";
            }
        ?>
    </div>
    <br><br><br>
    
    <table id="table" class="table table-striped table-hover">
        <tr>
            <th>Active</th>
            <th>Role</th>
            <th>Username</th>
            <th>Gender</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Room</th>
        </tr>
        <?php
        //Alle User werden in einer Liste ausgegeben
            while($stmt->fetch()){
                echo "<tr>";
                if($active == 1){echo "<td>Yes</td>";} else {echo "<td>No</td>";}
                echo "<td>".$role."</td>
                <td><a href='manageUser.php?user_to_manage_ID=" . $userID ."'>".$username."</td>
                <td>".$anrede."</td> 
                <td>".$vorname."</td>
                <td>".$nachname."</a></td>
                <td>". $room."</td>
                </tr>";
            }
            $stmt->close(); $db_obj->close();
        ?>
        </table>
</body>
</html>