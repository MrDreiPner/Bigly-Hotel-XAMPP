<?php //checkt ob Serviceperson eingeloggt ist
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin" && $_SESSION["SessionWert"] != "Service"){
            header("location: ../checks/UA_access.php");
        }
    }
    else{
        header("location: ../checks/UA_access.php");
    }
?>