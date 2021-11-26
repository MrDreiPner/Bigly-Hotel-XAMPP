<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <?php
        $checkschecked = "";
        $inputs = array ("nachname", "vorname", "email","anrede","tel","strasse","hausnummer","ort","plz", "Bildname");
        $inputsOnlyChars = array("nachname", "vorname", "ort", "strasse",);
        $data = array();
        $errors = array();

        foreach ($inputs as &$input){
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

        function checkTelefon($input){
            return preg_match("/^[0-9+ ]*$/",$input) ? "" : "Nur + in Vorwahl und Zahlen von 0-9 erlaubt!";
        }

        function checkEmail($input){
            return filter_var($input, FILTER_VALIDATE_EMAIL) ? "" : "Adresse ungültig!";
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $checkschecked = "Registrierung great success!";
            foreach($inputs as &$input) {
                $data[$input] = test_input($_POST[$input]);
            }
            foreach($inputsOnlyChars as &$input) {
                $errors[$input] = checkOnlyChars($data[$input]);
            }

            $errors["plz"] = checkOnlyNumbers($data["plz"]);
            $errors["hausnummer"] = checkOnlyCharsAndNumbers($data["hausnummer"]);
            $errors["email"] = checkEmail($data["email"]);
            $errors["tel"] = checkTelefon($data["tel"]);

            $counter = 0;
            foreach ($errors as &$error) {
                if ($error != "") {
                    $checkschecked = "Registrierung big fail!";
                }
        }}
     ?>
     <?php
        echo "<br><br><br>";
            $bildname = $data["Bildname"];
            if (isset($_FILES["Bildupload"])){
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/uploads/" .$bildname."_". uniqid().".". $path_parts["extension"];
            move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
        }
    
     ?>
    <div id="Header">
        <h1 id="Überschrift">Registrieren</h1>
    </div>
    <form enctype="multipart/form-data" method = "post">
        <div class="ersteClass">
            Anrede:
            <br>
            <br> <!--Überlegung ob Anrede notwendig bzw wie man Anrede genderneutral angehen kann-->
                <input name="anrede" type="radio" value="Herr" checked>Herr
                <input name="anrede" type="radio" value="Frau">Frau
                <input name="anrede" type="radio" value="Non-Binary">Non-Binary

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
            <label for="tel">Tel. Nummer:</label>
            <span class="error">* <?php echo $errors["tel"];?></span>
            <input type="tel" name="tel" id="tel" required value="<?php echo $errors["tel"] != "" ? "" : $data["tel"];?>">
        </div>
        <p class="ersteClass">Adresse:<br>
            <label>Straße:</label>
            <span class="error">* <?php echo $errors["strasse"];?></span>
            <input name="strasse" type="text" id="address" required value="<?php echo $errors["strasse"] != "" ? "" : $data["strasse"];?>"><br>
            <label>Hausnummer:</label>
            <span class="error">* <?php echo $errors["hausnummer"];?></span>
            <input name="hausnummer" type="text" id="address" required value="<?php echo $errors["hausnummer"] != "" ? "" : $data["hausnummer"];?>"><br>
            <label>Ort:</label>
            <span class="error">* <?php echo $errors["ort"];?></span>
            <input name="ort" type="text" id="address" required value="<?php echo $errors["ort"] != "" ? "" : $data["ort"];?>"><br>
            <label>PLZ:</label>
            <span class="error">* <?php echo $errors["plz"];?></span>
            <input name="plz" type="text" id="address" required value="<?php echo $errors["plz"] != "" ? "" : $data["plz"];?>"><br>
        </p>
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
   echo $data["email"],"<br>";
   echo $data["tel"],"<br>";
   echo $data["strasse"]," ",$data["hausnummer"],"<br>";
   echo $data["ort"]," ",$data["plz"],"<br>";

    echo "<h1> $checkschecked </h1>";
?>
</body>
</html>