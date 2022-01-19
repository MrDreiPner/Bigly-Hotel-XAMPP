<?php //Printet Namen der eingeloggten Person
        if (isset($_SESSION["SessionWert"])){
            echo "<li class='nav-item nav-link'>Hello ". $_SESSION["vorname"]."!</li>";
        }
?>
