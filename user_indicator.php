<?php //Printet Namen der eingeloggten Person
        if (isset($_SESSION["SessionWert"])){
            echo "<li class='nav-item'><a class='nav-link' href='/Hotelverwaltung_Faltas_Porubsky/Bigly-Hotel-XAMPP/user/userProfile.php'>Hello ". $_SESSION["vorname"]."!</a></li>";
        }
?>
