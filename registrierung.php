<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <?php
        require_once ('dbaccess.php');
        $checkschecked = "";
        $inputs = array ("nachname", "vorname", "email","anrede", "password","hausnummer", "room_nr");
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


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $checkschecked = "Registrierung great success!";
            foreach($inputs as $input) {
                $data[$input] = test_input($_POST[$input]);
            }
            foreach($inputsOnlyChars as $input) {
                $errors[$input] = checkOnlyChars($data[$input]);
            }

            $errors["email"] = checkEmail($data["email"]);
            $errors["room_nr"] = checkOnlyNumbers($data["room_nr"]);

            $counter = 0;
            foreach ($errors as &$error) {
                if ($error != "") {
                    $checkschecked = "Registrierung big fail!";
                }
        }}
        //$stmt->close(); $db_obj->close();
     ?>
    <div id="Header">
        <h1 id="Überschrift">Registrieren</h1>
    </div>
    <form enctype="multipart/form-data" method = "post">
        <div class="ersteClass">
            Anrede:
            <br>
            <br> <!--Überlegung ob Anrede notwendig bzw wie man Anrede genderneutral angehen kann-->
                <input name="anrede" type="radio" value=0 checked>Herr
                <input name="anrede" type="radio" value=1>Frau
                <input name="anrede" type="radio" value=2>Non-Binary

        </div>
        <br>
        <div class="ersteClass">
            <label for="vorname">Vorname:</label>
            <span class="error">* <?php echo $errors["vorname"];?></span>
            <input type="text" name="vorname" id="vorname" required value="<?php echo $errors["vorname"] != "" ? "" : $data["vorname"];?>"><br>
        </div>
        <div class="ersteClass">
            <label for="nachname">Nachname:</label>
            <span class="error">* <?php echo $errors["nachname"];?></span>
            <input type="text" name="nachname" id="nachname" required value="<?php echo $errors["nachname"] != "" ? "" : $data["nachname"];?>""><br>
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
            <span class="error">* <?php echo $errors["room_nr"];?></span>
            <input name="room_nr" type="text" id="room" required value="<?php echo $errors["room_nr"] != "" ? "" : $data["room_nr"];?>"><br>
        </div>
        <br>
        <input type="text" name="Bildname"><br>
        <input type="file" name="Bildupload"><br>
        <button type="submit">Registrieren</button>
        <button type="reset">Reset this</button>
    </form> 
<?php

   echo "<h2>Your Input:</h2>";
   echo $data["anrede"],"<br>";
   echo $data["vorname"], "<br>";
   echo $data["nachname"], "<br>";
   echo $data["password"],"<br>";
   echo $data["email"],"<br>";
   echo $data["room_nr"],"<br>";

    echo "<h1> $checkschecked </h1>";
?>
</body>
</html>