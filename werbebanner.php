<?php
    $user = array ("admin", "Thomas", "Patrick", "Matus"); 
    $werbung = array("harold1.jpg", "Wetten_dass.jpg", "Faltas.jpg", "MatPor.jpg");
    if (isset($_SESSION["SessionWert"])) {
        for ($index = 0; $index < sizeof($user); $index++) {
            if (($_SESSION["SessionWert"] == $user[$index])) {
                echo "<img src='Werbebilder/".$werbung[$index]."'>";
                break;
            }
        }
    }
?>