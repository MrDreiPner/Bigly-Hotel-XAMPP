<?php //Checkt ob Gast/Admin eingeloggt ist
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin" && $_SESSION["SessionWert"] != "Guest"){
            header("location: ../checks/UA_access.php");
        }
    } else{
        header("location: ../checks/UA_access.php");
    }
?>