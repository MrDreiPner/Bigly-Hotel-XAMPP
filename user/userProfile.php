<?php include ("../head.php"); ?>
<body>
<br><br><br><br><br>
    <?php 
        include ("../checks/user_logged_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
        
        if (isset($_SESSION["ID"])){
            $ID =$_SESSION["ID"];
            $sql = 'select username, email, room, vorname, nachname, role, anrede
                    from user
                    where userid = ?';
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $ID);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->bind_result($username, $email, $room, $Svorname, $Snachname, $role, $gender);
            $stmt->fetch();
            $stmt->close();
        }
        ?>
        <div id="form">    <!--Ausgabe der aktuellen Informationen -->
        <div id="inner-form">
            <h1 id="Überschrift">Manage Profile</h1>
            <div id="user-data">    
                Username: <?php echo $username;?><br>
                Gender: <?php echo $gender;?><br>
                Full name:<br> <?php echo $Svorname." ".$Snachname;?><br>
                E-Mail: <?php echo $email;?><br>
                Username: <?php echo $role;?><br>
                Room: <?php echo $room;?><br>
            </div>
        </div>
        </div>
        <?php
            if($_SESSION["SessionWert"] != "Service")
            {
                echo "<a class='btn btn-primary' href='/webtech/Bigly-Hotel-XAMPP/user/manageUser.php'>Manage Profile</a>";
            }
        ?>












    ?>