<?php
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin"){
            header("location: UA_access.php");
        }
    }
    else{
        header("location: UA_access.php");
    }
?>