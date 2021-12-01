<?php include "head.php"; ?>
<body>
    <?php include "nav.php"; ?>
    <br><br><br>
    <?php

        $user = array ("admin", "Thomas", "Patrick", "Matus"); 
        $PW = array("admin", "Gottschalk", "Faltas", "Porubsky");
        $werbung = array("harold1.jpg", "Wetten_dass.jpg", "Faltas.jpg", "MatPor.jpg");
        $verification = "Stop it";
        $validLogin = FALSE;
        if (isset($_POST["Username"])) {
            for ($index = 0; $index < sizeof($user); $index++) {
                if (($_POST["Username"] == $user[$index]) && ($_POST["Password"] == $PW[$index])) {
                    $verification = "You ". $user[$index]." now";
                    $validLogin = TRUE;
                    if (isset($_POST["Username"])) {
                        setcookie("CookieWert", $_POST["Username"], time()+3600);
                    }
                    if (isset($_POST["Username"])) {
                        $_SESSION["SessionWert"] = $_POST["Username"];
                    }
                    header("location: index.php");
                    break;
                }
            }
            echo $verification;
        }
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ", $_COOKIE["CookieWert"];
        }
        echo "<br>";

        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ", $_SESSION["SessionWert"];
        }
        $bildname = "";
        if (isset($_POST["Bildname"])) {
            $bildname = $_POST["Bildname"];
        }
        if (($validLogin == TRUE) && isset($_FILES["Bildupload"])) {
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            if (isset($path_parts["extension"])) {                    
                $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/Bigly Hotel XAMPP/personen/" .$bildname."_". uniqid().".".$path_parts["extension"];                
                move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
                var_dump($path_parts);
            }
        }
    ?>

    <form enctype="multipart/form-data" action="loginPage.php" method="POST">
        <label for="Username">Username</label>
        <input type="text" name="Username" required placeholder="Username" value="<?php echo isset($_COOKIE["CookieWert"]) ? $_COOKIE["CookieWert"] : "";?>"><br>
        <label for="Password">Password</label>
        <input type="password" required name="Password"><br>
        <label for="Bildname">Bild Titel</label>
        <input type="text" name="Bildname"><br>
        <input type="file" name="Bildupload"><br>
        <input type="submit">
    </form>

    <?php include "werbebanner.php";?>
    </body>
</html>