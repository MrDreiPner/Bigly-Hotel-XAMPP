<?php include ("../head.php"); ?>
<body>
    <?php 
        include ("../checks/user_guest_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
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
            header("location: ../checks/UA_access.php");
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

    <div id="form">    <!--Ausgabe der aktuellen Informationen -->
        <div id="inner-form">
            <h1 id="Überschrift">Manage Profile</h1>
            <div id="user-data">    
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
        </div>
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
            if($ch_password != $ch_password_c){
                $errors["ch_pw"] = $errors["ch_pw_c"] = "Passwords don't match!";
            }
            //Hier wird unabhängig vom user (verschiedene Inputs) der zugriff auf den weiteren Prozess zugelassen
            //Wobei geprüft wird, OB das Passwort verändert werden soll
            //Der Admin muss KEIN Passwort zur Aktualisierung eingeben - Der Gast schon
            else if(($ch_password != "" && $_SESSION["SessionWert"] == "Admin") || ($ch_password != "" && isset($_POST["safety_pw"]) && $_SESSION["SessionWert"] == "Guest"))
            {
                if($_SESSION["SessionWert"] == "Guest"){
                    //Hier wird die Richtigkeit des alten PW geprüft
                    $safety_pw = test_input($_POST["safety_pw"]);
                    if (password_verify($safety_pw, $OGpassword) && $safety_pw != ""){
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
                    else if(password_verify($safety_pw, $OGpassword) == FALSE && $safety_pw != ""){
                        $verification = "Old password wrong";
                        $errors["ch_pw"] = $errors["ch_pw_c"] = "Password NOT updated!";
                    }
                    else { 
                        $verification = "Missing old password!";
                        $errors["ch_pw"] = $errors["ch_pw_c"] = "Password NOT updated!";
                    }
                }
                else{
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
            if($errors["email"] == "" && $ch_email != ""){
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
        if(isset($_POST["ch_vorname"])){
            $vorname = test_input($_POST["ch_vorname"]);
            $errors["ch_vorname"] = checkOnlyChars($vorname);
            if($errors["ch_vorname"] == "" && $vorname != ""){
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

        if(isset($_POST["ch_nachname"])){
            $nachname = test_input($_POST["ch_nachname"]);
            $errors["ch_nachname"] = checkOnlyChars($nachname);
            if($errors["ch_nachname"] == "" && $nachname != ""){
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

        if(isset($_POST["ch_room"]) && $_SESSION["SessionWert"] == "Admin"){
            $ch_room = test_input($_POST["ch_room"]);
            $errors["ch_room"] = checkOnlyNumbers($ch_room);
            if($ch_room != ""){
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
            if($errors["ch_room"] == "" && $ch_room != ""){
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

        if(isset($_POST["anrede"])){
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

        if(isset($_POST["ch_role"]) && $_SESSION["SessionWert"] == "Admin"){
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

        if(isset($_POST["active"]) && $_SESSION["SessionWert"] == "Admin"){
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
        if(isset($_POST["sent"]) && $checkschecked == "Profile updated!"){
            $db_obj->close();
            unset($_SESSION['user_to_manage_ID']);
            $_SESSION["update"] = 1;
            $_SESSION["SessionWert"] == "Admin" ? header("Refresh:0 , url=userVerwaltung.php") : header("Refresh:0 , url=manageUser.php");
        }
        //Wenn 1 oder mehrere updates fehlgeschlagen sind, werden Gast und admin 3 Sekunden die Fehler angezeigt, dann
        //wird die Seite neu geladen, die erfolgreichen updates werden geladen
        else if(isset($_POST["sent"]) && $checkschecked != "Profile updated!"){
            $db_obj->close();
            $_SESSION["SessionWert"] == "Admin" ? header("Refresh:5 , url=manageUser.php") : header("Refresh:5 , url=manageUser.php");
        }

    ?>

    <div id="form">
        <div id="inner-form-ch">
            <h1 id="Überschrift">Update User Data</h1><br>
            <form method="POST" action="manageUser.php">
                <div id="mb-3">
                    <label for="ch_username" class="form-label" required>Change username: </label>
                    <span class="error"> <?php if(isset($errors["ch_username"])){ echo $errors["ch_username"];}?></span>
                    <input type="text" class="form-control" name="ch_username">
                </div>
            <?php
            if($_SESSION["SessionWert"] == "Guest"){
                echo 
                "<div id='mb-3'>
                    <label for='safety_pw' class='form-label' required>Old password: </label>
                    <span class='error'>";
                if(isset($verification)){ echo $verification;}
                echo
                "<input type='password' class='form-control' name='safety_pw'></div>";
            }
            ?>
                <div id="mb-3">
                    <label for="ch_pw" class="form-label" required>New password: </label>
                    <span class="error"> <?php if(isset($errors["ch_pw"])){ echo $errors["ch_pw"];}?></span>
                    <input type="password" class="form-control" name="ch_pw">
                </div>
                <div id="mb-3">
                    <label for="ch_pw_c" class="form-label" required>Confirm new password: </label>
                    <span class="error"> <?php if(isset($errors["ch_pw_c"])){ echo $errors["ch_pw_c"];}?></span>
                    <input type="password" class="form-control" name="ch_pw_c">
                </div>
                <div id="mb-3">
                    <label for="ch_email" class="form-label" required>Change E-Mail: </label>
                    <span class="error"> <?php if(isset($errors["email"])){ echo $errors["email"];}?></span>
                    <input type="email" class="form-control" name="ch_email">
                </div>
                <div id="mb-3">
                    <label for='ch_vorname' class="form-label" required>First Name: </label>
                    <span class='error'> <?php if(isset($errors["ch_vorname"])){ echo $errors["ch_vorname"];}?></span>
                    <input type='text' class="form-control" name='ch_vorname'>
                </div>
                <div id="mb-3">
                    <label for='ch_nachname' class="form-label" required>Last Name: </label>
                    <span class='error'> <?php if(isset($errors["ch_nachname"])){ echo $errors["ch_nachname"];}?></span>
                    <input type='text' class="form-control" name='ch_nachname'>   
                </div>
                Gender:<!--radios-->
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="anrede" id="inlineRadio1" value=1>
                    <label class="form-check-label" for="anrede">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="anrede" id="inlineRadio1" value=2>
                    <label class="form-check-label" for="anrede">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="anrede" id="inlineRadio1" value=3>
                    <label class="form-check-label" for="anrede">Non-Binary</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" checked name="anrede" id="inlineRadio1" value=4>
                    <label class="form-check-label" for="anrede">NA</label>
                </div>
            <?php
            //Die nachfolgenden Optionen sind nur für Admins nutzbar
            //Falls der Admin sich selbst bearbeitet, soll er diese Daten ebenfalls nicht bearbeiten können, damit er sich nicht selbst
            //die Rechte nimmt oder sich löscht
                if($_SESSION["SessionWert"] == "Admin" && isset($_SESSION["user_to_manage_ID"]) && $role != "Admin"){
                    echo 
                    "<div id='mb-3'>
                        <label for='ch_room' class='form-label' required>Room: </label><br>
                        <span class='error'></span>
                        <input type='text' class='form-control' name='ch_room'>
                    </div>";
                    if(isset($errors["ch_room"])){ echo $errors["ch_room"];} 
                    echo 
                    "<div class='form-check form-check-inline'>
                        <input class='form-check-input' type='checkbox' name='delete' id='inlineCheckbox1' value=1>
                        <label class='form-check-label' for='delete'>Delete User</label>
                    </div>
                    <div class='ersteClass'>Set Status: ";
                    if($Sactive == 0){
                        echo "<div class='form-check form-check-inline'>
                                <input class='form-check-input' type='radio' name='active' id='inlineRadio1' value=1>
                                <label class='form-check-label' for='active'>Active</label>
                            </div>";
                    }
                    else{
                        echo "<div class='form-check form-check-inline'>
                                <input class='form-check-input' type='radio' name='active' id='inlineRadio1' value=0>
                                <label class='form-check-label' for='active'>Inactive</label>
                            </div>";
                    }
                    echo "Role: 
                    <div class='form-check form-check-inline'>
                        <input class='form-check-input' type='radio' name='ch_role' id='inlineRadio1' value=2>
                        <label class='form-check-label' for='ch_role'>Service</label>
                    </div>
                    <div class='form-check form-check-inline'>
                        <input class='form-check-input' type='radio' name='ch_role' id='inlineRadio1' value=3>
                        <label class='form-check-label' for='ch_role'>Guest</label>
                    </div>";
                }
            ?>
                <input type ='hidden' name ='sent' value = '1'/>
                <input type="submit" id="submit" class="btn btn-primary" value="Update">
            </form>
        </div>
    <?php
        if(isset($_SESSION['update'])){
            echo "<br>". $checkschecked;
            unset($_SESSION['update']);
        }
    ?>
    </div>
</body>
</html>



