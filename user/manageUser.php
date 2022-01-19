<?php include ("../head.php"); ?>
<body>
<br><br><br><br><br>
    <?php 
        include ("../checks/user_guest_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_indicator.php");
        include ("../checks/test_input.php");//test_input() nutzen um rohe Daten zu testen, für mehr siehe test_input.php
    ?>
    <?php
        //Wenn der Admin über die userVerwaltung.php auf manageUser zugreift
        //wird die mitgeschickte ID hier in einen Session Wert gespeichert.
        //Es wird sichergestellt, dass die Session nur bei eingeloggten Admins gesetzt wird
        if(isset($_GET["user_to_manage_ID"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $_SESSION["user_to_manage_ID"] = $_GET["user_to_manage_ID"];
        }
        else if (isset($_GET["user_to_manage_ID"]) && $_SESSION["SessionWert"] != "Admin")
        {
            header("location: UA_access.php");
        }
        if (isset($_SESSION["ID"])){
            //Je nachdem wie auf manageUser zugegriffen wird, werden entweder die eigenen
            //Daten geholt (Gast) oder die des zu bearbeitenden users (als Admin)
            $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = 'select username, email, room, vorname, nachname, role, password, anrede, active
                    from user
                    where userid = ?';
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $ID);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->bind_result($username, $email, $room, $Svorname, $Snachname, $role, $OGpassword, $gender, $Sactive);
            $stmt->fetch();
            $stmt->close();
        }
    ?>
    <h1>Manage Profile</h1>
    <br><br><br><br>
    <!--Ausgabe der aktuellen Informationen -->
    <div class="input">
        Username: <?php echo $username;?><br>
        Gender: <?php echo $gender;?><br>
        Full name: <?php echo $Svorname." ".$Snachname;?><br>
        E-Mail: <?php echo $email;?><br>
        Username: <?php echo $role;?><br>
        Room: <?php echo $room;?><br>
        Active: <?php
                if($_SESSION["SessionWert"] == "Admin"){ 
                    if($Sactive == TRUE){echo "Active";}
                    else{echo "Inactive";}}
                ?><br>
    </div>
    <?php
        $checkschecked = "Profile updated!";
        $errors = array();

        //Wenn delete gesetzt wird und der Admin zugreift, wird der zu bearbeitende user gelöscht
        //Admins können nicht über die Seite gelöscht werden
        if(isset($_POST["delete"]) && $_SESSION["SessionWert"] == "Admin" && $role != "Admin")
        {
            $ID = $_SESSION["user_to_manage_ID"];
            $sql = "delete 
                   from user 
                   where userid = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $ID);
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
            header("Refresh:0; url=userVerwaltung.php");
        }
        //Der username wird aktualisiert - keine sonderzeichen erlaubt
        if(isset($_POST["ch_username"])){
            $ch_username = test_input($_POST["ch_username"]);
            $errors["ch_username"] = checkOnlyCharsAndNumbersNoSpace($ch_username);
            //Hier wird geprüft ob es den username bereits in der DB gibt
            $sql = "SELECT username FROM user WHERE username = '$ch_username'"; 
            $result = $db_obj->query($sql); 
            $count = mysqli_num_rows($result); 
            if ($count >= 1){ 
                $errors["ch_username"] = "This username is already used!"; 
            }
            $result->close();
            //Wenn alles passt, werden die Daten in der DB aktualisiert
            if($errors["ch_username"] == "" && $ch_username != "")
            {
                $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set username = ?
                    where userID = ?";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('si', $ch_username, $ID);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
        }
        //zuerst wird geprüft ob das neue PW zweimal ident eingegeben wurde
        if(isset($_POST["ch_pw"]) && isset($_POST["ch_pw_c"])){
            $ch_password = test_input($_POST["ch_pw"]);
            $ch_password_c = test_input($_POST["ch_pw_c"]);
            if($ch_password != $ch_password_c)
            {
                $errors["ch_pw"] = $errors["ch_pw_c"] = "Passwords don't match!";
            }
            //Hier wird unabhängig vom user (verschiedene Inputs) der zugriff auf den weiteren Prozess zugelassen
            //Wobei geprüft wird, OB das Passwort verändert werden soll
            //Der Admin muss KEIN Passwort zur Aktualisierung eingeben - Der Gast schon
            else if(($ch_password != "" && $_SESSION["SessionWert"] == "Admin") || ($ch_password != "" && isset($_POST["safety_pw"]) && $_SESSION["SessionWert"] == "Guest"))
            {
                if($_SESSION["SessionWert"] == "Guest")
                {
                    //Hier wird die Richtigkeit des alten PW geprüft
                    $safety_pw = test_input($_POST["safety_pw"]);
                    if (password_verify($safety_pw, $OGpassword) && $safety_pw != "")
                    {
                        $ID = $_SESSION["ID"];
                        $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                        $sql = "update user 
                                set password = ?
                                where userID = ?";
                        $stmt = $db_obj->prepare($sql);
                        $stmt->bind_param('ssi', $ch_password, $ID);
                        if ($stmt===false){
                            echo($db_obj->error);
                            echo "fail";
                        }
                        $stmt->execute();
                        $stmt->close();
                    }
                    else if(password_verify($safety_pw, $OGpassword) == FALSE && $safety_pw != "")
                    {
                        $verification = "Old password wrong";
                        $errors["ch_pw"] = $errors["ch_pw_c"] = "Password NOT updated!";
                    }
                    else { 
                        $verification = "Missing old password!";
                        $errors["ch_pw"] = $errors["ch_pw_c"] = "Password NOT updated!";
                    }
                }
                else
                {
                    $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                    $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                    $sql = "update user 
                            set password = ?
                            where userID = ?";
                    $stmt = $db_obj->prepare($sql);
                    $stmt->bind_param('ssi', $ch_password, $ID);
                    if ($stmt===false){
                        echo($db_obj->error);
                        echo "fail";
                    }
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
        //Die Anweisungsblöcke sind seperat, damit einzelne unabhängige updates gemacht werden können
        if(isset($_POST["ch_email"]) && $_POST["ch_email"] != ""){
            $ch_email = test_input($_POST["ch_email"]);
            $errors["email"] = checkEmail($ch_email);
            if($errors["email"] == "" && $ch_email != "")
            {
                $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set email = ?
                    where userID = ?";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('si', $ch_email, $ID);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();     
            }
        }
        if(isset($_POST["ch_vorname"]))
        {
            $vorname = test_input($_POST["ch_vorname"]);
            $errors["ch_vorname"] = checkOnlyChars($vorname);
            if($errors["ch_vorname"] == "" && $vorname != "")
            {
                $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set vorname = ?
                    where userID = ?";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('si', $vorname, $ID);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $_SESSION["vorname"] = $vorname;
                $stmt->close();
            }
        }

        if(isset($_POST["ch_nachname"]))
        {
            $nachname = test_input($_POST["ch_nachname"]);
            $errors["ch_nachname"] = checkOnlyChars($nachname);
            if($errors["ch_nachname"] == "" && $nachname != "")
            {
                $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set nachname = ?
                    where userID = ?";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('si', $nachname, $ID);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST["ch_room"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ch_room = test_input($_POST["ch_room"]);
            $errors["ch_room"] = checkOnlyNumbers($ch_room);
            if($ch_room != "")
            {
                //Es wird geprüft ob das Zimmer bereits vergeben ist
                $sql = "SELECT room FROM user 
                        WHERE room = '$ch_room' 
                        and active = 1
                        and (role != 'Admin' 
                        or 'Service')"; 
                $result = $db_obj->query($sql); 
                $count = mysqli_num_rows($result); 
                if ($count >= 1){ 
                    $errors["ch_room"] = "Room already occupied!"; 
                }
                $result->close();
            }
            if($errors["ch_room"] == "" && $ch_room != "")
            {
                $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set room = ?
                    where userID = ?";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('ii', $ch_room, $ID);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST["anrede"]))
        {
            $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set anrede = ?
                where userID = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('ii', $_POST["anrede"], $ID);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST["ch_role"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set role = ?
                where userID = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('ii', $_POST["ch_role"], $ID);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST["active"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = isset($_SESSION["user_to_manage_ID"])?$_SESSION["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set active = ?
                where userID = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('ii', $_POST["active"], $ID);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }
        //Es wird geprüft ob es Fehler bei updates gab
        foreach ($errors as $error) {
            if ($error != "") {
                $checkschecked = "PARTIAL OR NO PROFILE UPDATE!";
                $_SESSION["update"] = 1;
            }
        }
        //Wenn alle updates erfolgreich waren wird der admin zurück in die user verwaltung geschickt, der gast bleibt
        if(isset($_POST["sent"]) && $checkschecked == "Profile updated!")
        {
            $db_obj->close();
            unset($_SESSION['user_to_manage_ID']);
            $_SESSION["update"] = 1;
            $_SESSION["SessionWert"] == "Admin" ? header("Refresh:0 , url=userVerwaltung.php") : header("Refresh:0 , url=manageUser.php");
        }
        //Wenn 1 oder mehrere updates fehlgeschlagen sind, werden Gast und admin 3 Sekunden die Fehler angezeigt, dann
        //wird die Seite neu geladen, die erfolgreichen updates werden geladen
        else if(isset($_POST["sent"]) && $checkschecked != "Profile updated!")
        {
            $db_obj->close();
            $_SESSION["SessionWert"] == "Admin" ? header("Refresh:5 , url=manageUser.php") : header("Refresh:5 , url=manageUser.php");
        }


    ?>
    <br><br>
    <div class="input">
    <form method="POST" action="manageUser.php">
        <h3>Update Data</h3>
        <label for="ch_username" required>Change username: </label><br>
        <input type="text" name="ch_username">
        <span class="error"> <?php if(isset($errors["ch_username"])){ echo $errors["ch_username"];}?></span><br>
        <?php
            if($_SESSION["SessionWert"] == "Guest")
            {
                echo 
                "<label for='safety_pw' required>Old password: </label><br>
                <span class='error'>";
                if(isset($verification)){ echo $verification;}
                echo
                "</span><input type='password' name='safety_pw'><br>";
            }
        ?>
        <label for="ch_pw" required>New password: </label><br>
        <input type="password" name="ch_pw">
        <span class="error"> <?php if(isset($errors["ch_pw"])){ echo $errors["ch_pw"];}?></span><br>
        <label for="ch_pw_c" required>Confirm new password: </label><br>
        <input type="password" name="ch_pw_c">
        <span class="error"> <?php if(isset($errors["ch_pw_c"])){ echo $errors["ch_pw_c"];}?></span><br>
        <label for="ch_email" required>Change E-Mail: </label><br>
        <input type="email" name="ch_email">
        <span class="error"> <?php if(isset($errors["email"])){ echo $errors["email"];}?></span><br>
        <label for='ch_vorname' required>First Name: </label><br>
        <input type='text' name='ch_vorname'>
        <span class='error'> <?php if(isset($errors["ch_vorname"])){ echo $errors["ch_vorname"];}?> </span><br>
        <label for='ch_nachname' required>Last Name: </label><br>
        <input type='text' name='ch_nachname'>
        <span class='error'> <?php if(isset($errors["ch_nachname"])){ echo $errors["ch_nachname"];}?></span><br>
        <div class='ersteClass'>
            Gender:<br>
                <input name='anrede' type='radio' value=1>Male
                <input name='anrede' type='radio' value=2>Female
                <input name='anrede' type='radio' value=3>Non-Binary
                <input name='anrede' type='radio' value=4>NA
                <br>
        </div>
        <?php
        //Die nachfolgenden Optionen sind nur für Admins nutzbar
        //Falls der Admin sich selbst bearbeitet, soll er diese Daten ebenfalls nicht bearbeiten können, damit er sich nicht selbst
        //die Rechte nimmt oder sich löscht
            if($_SESSION["SessionWert"] == "Admin" && isset($_SESSION["user_to_manage_ID"]) && $role != "Admin")
            {
                echo 
                "<label for='ch_room' required>Room: </label><br>
                <span class='error'></span><input type='text' name='ch_room'>";
                if(isset($errors["ch_room"])){ echo $errors["ch_room"];} 
                echo 
                "<div class='ersteClass'>Delete User:
                <input name='delete' type='checkbox' value=1><br></div>
                <div class='ersteClass'>
                Role: <input name='ch_role' type='radio' value=2>Service
                <input name='ch_role' type='radio' value=3>Guest<br>
                </div>
                <div class='ersteClass'>Set Status: ";
                if($Sactive == 0)
                {
                    echo "<input name='active' type='radio' value=1>Active<br></div>";
                }
                else
                {
                    echo "<input name='active' type='radio' value=0>Inactive<br></div>";
                }
            }
        ?>
        <input type ='hidden' name ='sent' value = '1'/>
        <input type="submit" value="Update">
    </form>
    <?php
        if(isset($_SESSION['update']))
        {
            echo "<br>". $checkschecked;
            unset($_SESSION['update']);
        }
    if($_SESSION["SessionWert"] == "Admin")
    {
        echo "<form action='userVerwaltung.php'><input type='submit' value='Back'></form>";
    }
    else
    {
        echo "<form action='../main/index.php'><input type='submit' value='Back'></form>";
    }
    ?>
    </div>

</body>
</html>