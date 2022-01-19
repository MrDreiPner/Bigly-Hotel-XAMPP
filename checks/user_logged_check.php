<?php
    if(!isset($_SESSION["SessionWert"])){
        header("location: ../checks/UA_access.php");
    }
?>