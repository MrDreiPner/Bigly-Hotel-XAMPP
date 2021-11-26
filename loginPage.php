<?php include "head.php"; ?>
<body>
    <?php include "nav.php"; ?>
    <br><br><br>
    <?php
        session_start();

        $user = array ("admin", "Thomas"); 
        $PW = array("admin", "Gottschalk");
        $verification = "Stop it";
        if (isset($_POST["Username"])) {
            for ($index =0; $index < sizeof($user); $index++) {
                if (($_POST["Username"] == $user[$index]) && ($_POST["Password"] == $PW[$index])) {
                    $verification = "You sudo now";
                    break;
                }
            }
            echo $verification;
        }

        echo "<br>";
        $uploadDir = $_SERVER["DOCUMENT_ROOT"]."/WebTech/uploads/". uniqid().".txt";
        if (isset($_POST["Username"])){
            setcookie("CookieWert", $_POST["Username"], time()+30);
        }

        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ", $_COOKIE["CookieWert"];
        }

        if (isset($_POST["Username"])){
            $_SESSION["SessionWert"] = $_POST["Username"];
        }

        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ", $_SESSION["SessionWert"];
        }
        if (isset($_POST["Bildupload"])) {
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/personen/" .$_POST["Bildname"]."_". uniqid().".". $path_parts["extension"];
            move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
        }
    ?>

    <form enctype="multipart/form-data" action="loginPage.php" method="POST">
        <label for="Username">Username</label>
        <input type="text" name="Username" required placeholder="Username"><br>
        <label for="Password">Password</label>
        <input type="password" required name="Password"><br>
        <label for="Bildname">Bild Titel</label>
        <input type="text" name="Bildname"><br>
        <input type="file" name="Bildupload"><br>
        <input type="submit">
    </form>
</body>
</html>