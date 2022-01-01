<?php
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin" && $_SESSION["SessionWert"] != "Service"){
            header("location: UA_access.php");
        }
    }
    else{
        header("location: UA_access.php");
    }
?>