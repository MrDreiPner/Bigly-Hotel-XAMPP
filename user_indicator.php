<?php
        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ". $_SESSION["SessionWert"];
            echo "<br>User: ". $_SESSION["User"];
        }
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ". $_COOKIE["CookieWert"];
        }
?>