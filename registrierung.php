<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <br><br><br>
    <?php
        require_once ('dbaccess.php');
        $checkschecked = "";
        $inputs = array ("nachname", "vorname", "email","anrede", "room_nr", "role", "password");
        $inputsOnlyChars = array("nachname", "vorname");
        $data = array();
        $errors = array();

        foreach ($inputs as $input){
            $data[$input] = "";
            $errors[$input] = "";
        }
    
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function checkOnlyChars($input){
            return preg_match("/^[a-zA-Z]*$/",$input) ? "" : "Nur Buchstaben erlaubt!";
        }

        function checkOnlyNumbers($input){
            return preg_match("/^[0-9]*$/",$input) ? "" : "Nur Zahlen erlaubt!";
        }

        function checkOnlyCharsAndNumbers($input){
            return preg_match("/^[a-zA-Z0-9]*$/",$input) ? "" : "Keine Sonderzeichen erlaubt!";
        }

        /*function checkTelefon($input){
            return preg_match("/^[0-9+ ]*$/",$input) ? "" : "Nur + in Vorwahl und Zahlen von 0-9 erlaubt!";
        }*/

        function checkEmail($input){
            return filter_var($input, FILTER_VALIDATE_EMAIL) ? "" : "Adresse ungültig!";
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

            //$counter = 0;
            foreach ($errors as $error) {
                if ($error != "") {
                    $checkschecked = "Registrierung big fail!";
                }
        }
        if($checkschecked == "Registrierung great success!")
        {
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
        }
    }
        
    ?>
    <div id="Header">
        <h1 id="Überschrift">Registrieren</h1>
    </div>
    <form enctype="multipart/form-data" method = "post">
        <div class="ersteClass">
            Anrede:
            <br> <!--Überlegung ob Anrede notwendig bzw wie man Anrede genderneutral angehen kann-->
                <input name="anrede" type="radio" value=1>Herr
                <input name="anrede" type="radio" value=2>Frau
                <input name="anrede" type="radio" value=3>Non-Binary
                <input name="anrede" type="radio" value=4 checked>NA


        </div>
        <br> 
        <div class="ersteClass">
            Rolle:
            <br>
                <input name="role" type="radio" value=1>Admin
                <input name="role" type="radio" value=2 checked>Service
                <input name="role" type="radio" value=3>Gast
        </div>
        <br>
        <div class="ersteClass">
            <label for="vorname">Vorname:</label>
            <span class="error"> <?php echo $errors["vorname"];?></span>
            <input type="text" name="vorname" id="vorname" value="<?php echo $errors["vorname"] != "" ? "" : $data["vorname"];?>"><br>
        </div>
        <div class="ersteClass">
            <label for="nachname">Nachname:</label>
            <span class="error"> <?php echo $errors["nachname"];?></span>
            <input type="text" name="nachname" id="nachname" value="<?php echo $errors["nachname"] != "" ? "" : $data["nachname"];?>""><br>
        </div>
        <div class="ersteClass">
            <label for="email">E-Mail-Adresse:</label>
            <span class="error">* <?php echo $errors["email"];?></span>
            <input type="email" name="email" id="email" required value="<?php echo $errors["email"] != "" ? "" : $data["email"];?>"><br>
        </div>
        <div class="ersteClass">
            <label for="password">Password:</label>
            <span class="error">* <?php echo $errors["password"];?></span>
            <input type="password" name="password" id="password" required value="<?php echo $errors["password"] != "" ? "" : $data["password"];?>">
        </div>
        <div class="ersteClass">
            <label>Room:</label>
            <span class="error"> <?php echo $errors["room_nr"];?></span>
            <input name="room_nr" type="text" id="room" value="<?php echo $errors["room_nr"] != "" ? "" : $data["room_nr"];?>"><br>
        </div>
        <br>
        <button type="submit">Registrieren</button>
        <button type="reset">Reset this</button>
    </form> 
<?php

   echo "<h2>Your Input:</h2>";
   echo $data["anrede"],"<br>";
   echo $data["role"],"<br>";
   echo $data["vorname"], "<br>";
   echo $data["nachname"], "<br>";
   echo $data["password"], "<br>";
   echo $data["email"],"<br>";
   echo $data["room_nr"],"<br>";

echo "<h1> $checkschecked </h1>";
?>
</body>
</html>