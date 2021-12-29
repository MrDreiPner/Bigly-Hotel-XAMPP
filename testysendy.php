<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <form enctype="multipart/form-data" method = "post" action="verytesty.php">
    <br><br><br><br>
            <div class="ersteClass">
                <label for="vorname">Vorname:</label>
                <!--<span class="error">* <?php //echo $errors["vorname"];?></span>-->
                <input type="text" name="vorname" id="vorname"><br>
            </div>
            <div class="ersteClass">
                <label for="nachname">Nachname:</label>
                <!--<span class="error">* <?php //echo $errors["nachname"];?></span>-->
                <input type="text" name="nachname" id="nachname"><br>
            </div>
            <div class="ersteClass">
                <label for="passwort">Passwort:</label>
                <!--<span class="error">* <?php //echo $errors["nachname"];?></span>-->
                <input type="text" name="passwort" id="passwort"><br>
            </div>
            <button type="submit">Registrieren</button>
    </form>
    <?php
        require_once ('dbaccess.php');
        
        if(isset($_POST["filter"])){
            $sql = "select vorname, nachname, password from user where nachname = ?";
        } else {
            $sql = "select vorname, nachname, password from user";
        }

        $stmt = $db_obj->prepare($sql);

        if(isset($_POST["filter"])){
            $filter = $_POST["filter"];
            $stmt-> bind_param("s", $filter);
        }

        $stmt->execute();

        $stmt->bind_result($vorname, $nachname, $passwort);

        echo "<ul>";
        while ($stmt->fetch())
        {
            echo "<li>" . $vorname . " " . $nachname . " " . $passwort ."</li>";
        }
        echo "</ul>";

        $stmt->close(); $db_obj->close();
    ?>
</body>
</html>