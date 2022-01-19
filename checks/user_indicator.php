<?php //Printet Namen der eingeloggten Person
        if (isset($_SESSION["SessionWert"])){
            echo "<br>Hello ". $_SESSION["vorname"];
        }
?>