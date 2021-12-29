<?php 
    if(isset($_SESSION["SessionWert"])){
        if ($_SESSION["SessionWert"] == "Admin"){
        $host = "localhost";
        $user = "admin";
        $password = "admin";
        $database = "bighotel_db";
        $db_obj = new mysqli($host, $user, $password, $database);
        }
        else if ($_SESSION["SessionWert"] == "Service"){
        $host = "localhost";
        $user = "service";
        $password = "service";
        $database = "bighotel_db";
        $db_obj = new mysqli($host, $user, $password, $database);
        }
        else if ($_SESSION["SessionWert"] == "Guest"){
        $host = "localhost";
        $user = "guest";
        $password = "guest";
        $database = "bighotel_db";
        $db_obj = new mysqli($host, $user, $password, $database);
        }
    }
    else {
        $host = "localhost";
        $user = "login";
        $password = "login";
        $database = "bighotel_db";
        $db_obj = new mysqli($host, $user, $password, $database);
        }
?>