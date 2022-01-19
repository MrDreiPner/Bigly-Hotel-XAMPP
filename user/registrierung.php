<?php include ("../head.php"); ?>
<body>
    <br><br><br>
    <?php
        include ("../checks/user_admin_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_indicator.php");
        include ("../checks/test_input.php");//test_input() nutzen um rohe Daten zu testen, für mehr siehe test_input.php
    ?>
    <br><br><br>
    <?php
        $checkschecked = "";
        $inputs = array ("nachname", "vorname", "email","anrede", "room_nr", "role", "password");
        $inputsOnlyChars = array("nachname", "vorname");
        $data = array();
        $errors = array();

        foreach ($inputs as $input){
            $data[$input] = "";
            $errors[$input] = "";
        }
        
        $checkschecked = "Registrierung great success!";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach($inputs as $input) {
                $data[$input] = test_input($_POST[$input]);
            }
            foreach($inputsOnlyChars as $input) {
                $errors[$input] = checkOnlyChars($data[$input]);
            }
            $errors["email"] = checkEmail($data["email"]);
            $errors["room_nr"] = checkOnlyNumbers($data["room_nr"]);

            $sql = "SELECT username FROM user WHERE username = '$data[email]'"; 
            $result = $db_obj->query($sql); 
            $count = mysqli_num_rows($result); 
            if ($count >= 1){ 
                $errors["email"] = "This e-mail/ username is already used!"; 
            }
            if($data["room_nr"] != "")
            {
                //Es wird geprüft ob das Zimmer bereits vergeben ist
                $room_oc = $data["room_nr"];
                $sql = "SELECT room FROM user 
                        WHERE room = '$room_oc' 
                        and active = 1
                        and (role != 'Admin' 
                        or 'Service')"; 
                $result = $db_obj->query($sql); 
                $count = mysqli_num_rows($result); 
                if ($count >= 1){ 
                    $errors["room_nr"] = "Room already occupied!"; 
                }
                $result->close();
            }
            foreach ($errors as $error) {
                if ($error != "") {
                    $checkschecked = "Registrierung big fail!";
                }
        }
        if($checkschecked == "Registrierung great success!")
        {   //Neuer User wird in Datenbank aufgenommen
            $sql = "INSERT INTO user (username, Vorname, Nachname, pw_notiz, password, email, anrede, role, room, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, true)";
            $stmt = $db_obj->prepare($sql);

            if ($stmt===false){
                echo($db_obj->error);
            }

            $username = $data["email"];
            $vorname= $data["vorname"];
            $nachname = $data["nachname"];
            $pw_notiz = $data["password"];
            //Passwort wird sofort gehasht
            $password = password_hash($pw_notiz, PASSWORD_DEFAULT);
            $email = $data["email"];
            $anrede = $data["anrede"];
            $role = $data["role"];
            $room_nr = $data["room_nr"];
            $stmt->bind_param("ssssssiii", $username, $vorname, $nachname, $pw_notiz, $password, $email, $anrede, $role, $room_nr);
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            header("Refresh:0; url=userVerwaltung.php");
        }
    }
        
    ?>
    <div id="Header">
        <h1 id="Überschrift">User Registration</h1>
    </div>
    <div id="form">
        <div id="inner-form">
            <form enctype="multipart/form-data" method = "post">
                <div class="form-check">
                Gender:
                <br>
                <input name="anrede" type="radio" value=1>Male
                <input name="anrede" type="radio" value=2>Female
                <input name="anrede" type="radio" value=3>Non-Binary
                <input name="anrede" type="radio" value=4 checked>NA
            </div>
            <br> 
            <div class="ersteClass">
                Role:
                <br>
                <input name="role" type="radio" value=1>Admin
                <input name="role" type="radio" value=2>Service
                <input name="role" type="radio" value=3 checked>Guest
            </div>
            <br>
            <div class="ersteClass">
                <label for="email">E-Mail/ Username:</label>
                <span class="error">* <?php echo $errors["email"];?></span>
                <input type="email" name="email" id="email" required value="<?php echo $errors["email"] != "" ? "" : $data["email"];?>"><br>
            </div>
            <div class="ersteClass">
                <label for="password">Password:</label>
                <span class="error">* <?php echo $errors["password"];?></span>
                <input type="password" name="password" id="password" required value="<?php echo $errors["password"] != "" ? "" : $data["password"];?>">
            </div>
            <div class="ersteClass">
                <label for="vorname">First Name:</label>
                <span class="error"> <?php echo $errors["vorname"];?></span>
                <input type="text" name="vorname" id="vorname" value="<?php echo $errors["vorname"] != "" ? "" : $data["vorname"];?>"><br>
            </div>
            <div class="ersteClass">
                <label for="nachname">Last Name:</label>
                <span class="error"> <?php echo $errors["nachname"];?></span>
                <input type="text" name="nachname" id="nachname" value="<?php echo $errors["nachname"] != "" ? "" : $data["nachname"];?>"><br>
             </div>
            <div class="ersteClass">
                <label>Room:</label>
                <span class="error"> <?php echo $errors["room_nr"];?></span>
                <input name="room_nr" type="text" id="room" value="<?php echo $errors["room_nr"] != "" ? "" : $data["room_nr"];?>"><br>
            </div>
            <br>
            <button type="submit">Register</button>
            <button type="reset">Reset page</button>
        </form> 
    </div
</html>