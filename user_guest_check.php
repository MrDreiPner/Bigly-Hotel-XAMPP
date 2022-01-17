<?php //Checkt ob Gast eingeloggt ist
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin" && $_SESSION["SessionWert"] != "Guest"){
            header("location: UA_access.php");
        }
    } else{
        header("location: UA_access.php");
    }
?>