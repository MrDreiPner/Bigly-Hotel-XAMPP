<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Lato:ital,wght@1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Registrierung</title>
</head>
<body>
    <?php
        include "nav.php";
    ?>
    <?php
        $nachname = $vorname = $email = $anrede = $tel = $strasse = $hausnummer = $ort = $plz = "";
        $missNachname = $missVorname = $missEmail = $missAnrede = $missTel = $missStrasse = $missHausnummer = $missOrt = $missPlz = "";
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["Nachname"])){
                $missNachname = "Gib Nachname";
            }
            else{
                $nachname = test_input($_POST["Nachname"]);
            }
            if (empty($_POST["Vorname"])){
                $missVorname = "Gib Vorname";
            }
            else{
                $vorname = test_input($_POST["Vorname"]);
            }
            if (empty($_POST["anrede"])){
                $missAnrede = "Gib Anrede";
            }
            else{
                $anrede = test_input($_POST["anrede"]);
            }
            if (empty($_POST["email"])){
                $missEmail = "Gib E-Mail";
            }
            else{
                $email = test_input($_POST["email"]);
            }
            if (empty($_POST["tel"])){
                $missTel = "Gib Telefonnummer";
            }
            else{
                $tel = test_input($_POST["tel"]);
            }
            if (empty($_POST["strasse"])){
                $missStrasse = "Gib Straße";
            }
            else{
                $strasse = test_input($_POST["strasse"]);
            }
            if (empty($_POST["hausnummer"])){
                $missHausnummer = "Gib Hausnummer";
            }
            else{
                $hausnummer = test_input($_POST["hausnummer"]);
            }
            if (empty($_POST["ort"])){
                $missOrt = "Gib Ort";
            }
            else{
                $ort = test_input($_POST["ort"]);
            }
            if (empty($_POST["plz"])){
                $missPlz = "Gib Postleitzahl";
            }
            else{
                $plz = test_input($_POST["plz"]);
            }
        }
    
        function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }
    ?>
    <div id="Header">
        <h1 id="Überschrift">Registrieren</h1>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" target="_blank">
        <div class="ersteClass">
            Anrede:
            <br>
            <span class="error">* <?php echo $missAnrede;?></span>
            <br> <!--Überlegung ob Anrede notwendig bzw wie man Anrede genderneutral angehen kann-->
                <input name="anrede" type="radio" value="Herr" checked>Herr
                <input name="anrede" type="radio" value="Frau">Frau
                <input name="anrede" type="radio" value="Non-Binary">Non-Binary

        </div>
        <br>
        <div class="ersteClass">
            <label for="Vorname">Vorname:</label>
            <span class="error">* <?php echo $missVorname;?></span>
            <input type="text" name="Vorname" id="Vorname"><br>
        </div>
        <div class="ersteClass">
            <label for="Nachname">Nachname:</label>
            <span class="error">* <?php echo $missNachname;?></span>
            <input type="text" name="Nachname" id="Nachname"><br>
        </div>
        <div class="ersteClass">
            <label for="email">E-Mail-Adresse:</label>
            <span class="error">* <?php echo $missEmail;?></span>
            <input type="email" name="email" id="email"><br>
        </div>
        <div class="ersteClass">
            <label for="tel">Tel. Nummer:</label>
            <span class="error">* <?php echo $missTel;?></span>
            <input type="tel" name="tel" id="tel">
        </div>
        <p class="ersteClass">Adresse:<br>
            <label>Straße:</label>
            <span class="error">* <?php echo $missStrasse;?></span>
            <input name="strasse" type="text" id="address"><br>
            <label>Hausnummer:</label>
            <span class="error">* <?php echo $missHausnummer;?></span>
            <input name="hausnummer" type="text" id="address"><br>
            <label>Ort:</label>
            <span class="error">* <?php echo $missOrt;?></span>
            <input name="ort" type="text" id="address"><br>
            <label>PLZ:</label>
            <span class="error">* <?php echo $missPlz;?></span>
            <input name="plz" type="text" id="address"><br>
        </p>
        <button type="submit">Registrieren</button>
    </form>
 <?php
    echo "<h2>Your Input:</h2>";
    echo $vorname, "<br>";
    echo $nachname, "<br>";
    echo $anrede,"<br>";
    echo $email,"<br>";
    echo $tel,"<br>";
    echo $strasse,"<br>";
    echo $hausnummer,"<br>";
    echo $ort,"<br>";
    echo $plz;
?>
</body>
</html>