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

            $sql = "SELECT email FROM user WHERE email = '$data[email]'"; 
            $result = $db_obj->query($sql); 
            $count1 = mysqli_num_rows($result); 
            $sql = "SELECT username FROM user WHERE username = '$data[email]'"; 
            $result = $db_obj->query($sql); 
            $count = mysqli_num_rows($result); 
            if ($count >= 1 || $count1 >= 1){ 
                $errors["email"] = "This e-mail/ username is already used!"; 
            }
            if($data["room_nr"] != "" && $errors["room_nr"] == "")
            {
                //Es wird geprüft ob das Zimmer bereits vergeben ist
                $room_oc = $data["room_nr"];
                if($data["role"] == 3)
                {
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
            }
            foreach ($errors as $error) {
                if ($error != "") {
                    $checkschecked = "Registrierung big fail!";
                }
        }
        if($checkschecked == "Registrierung great success!")
        {   //Neuer User wird in Datenbank aufgenommen
            $sql = "INSERT INTO user (username, Vorname, Nachname, password, email, anrede, role, room, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, true)";
            $stmt = $db_obj->prepare($sql);

            if ($stmt===false){
                echo($db_obj->error);
            }

            $username = $data["email"];
            $vorname= $data["vorname"];
            $nachname = $data["nachname"];
            $password_checked = $data["password"];
            //Passwort wird gehasht
            $password = password_hash($password_checked, PASSWORD_DEFAULT);
            $email = $data["email"];
            $anrede = $data["anrede"];
            $role = $data["role"];
            $room_nr = $data["room_nr"];
            $stmt->bind_param("sssssiii", $username, $vorname, $nachname, $password, $email, $anrede, $role, $room_nr);
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            header("Refresh:0; url=userVerwaltung.php");
        }
    }
    ?>
   <div id="form">
        <div id="inner-form-addUser">
            <h1 id="Überschrift">User Registration</h1><br>
            <form enctype="multipart/form-data" method = "post">
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
            <br>Role:
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value=1>
                    <label class="form-check-label" for="role">Admin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value=2>
                    <label class="form-check-label" for="role">Service</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="inlineRadio1" checked value=3>
                    <label class="form-check-label" for="role">Guest</label>
                </div><!--radio end-->
                <div id="mb-3">
                    <label for="email" class="form-label">E-Mail/ Username:</label>
                    <span class="error">* <?php echo $errors["email"];?></span>
                    <input type="email" class="form-control" name="email" id="email" required value="<?php echo $errors["email"] != "" ? "" : $data["email"];?>"><br>
                </div>
                <div id="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <span class="error">* <?php echo $errors["password"];?></span>
                    <input type="password" class="form-control" name="password" id="password" required value="<?php echo $errors["password"] != "" ? "" : $data["password"];?>">
                </div>
                <div id="mb-3">
                    <label for="vorname" class="form-label">First Name:</label>
                    <span class="error"> <?php echo $errors["vorname"];?></span>
                    <input type="text" class="form-control" name="vorname" id="vorname" value="<?php echo $errors["vorname"] != "" ? "" : $data["vorname"];?>"><br>
                </div>
                <div id="mb-3">
                    <label for="nachname" class="form-label">Last Name:</label>
                    <span class="error"> <?php echo $errors["nachname"];?></span>
                    <input type="text" class="form-control" name="nachname" id="nachname" value="<?php echo $errors["nachname"] != "" ? "" : $data["nachname"];?>"><br>
                </div>
                <div id="mb-3">
                    <label class="form-label" for="room_nr">Room:</label>
                    <span class="error"> <?php echo $errors["room_nr"];?></span>
                    <input name="room_nr" class="form-control" type="text" id="room" value="<?php echo $errors["room_nr"] != "" ? "" : $data["room_nr"];?>"><br>
                </div>
            <br>
            <button type="submit" id="submit" class="btn btn-primary">Register</button>
            <button type="reset" id="submit" class="btn btn-primary">Reset page</button>
        </form> 
    </div
</html>