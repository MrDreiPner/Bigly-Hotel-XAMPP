<?php //Checkt ob Admin eingeloggt ist
    if(isset($_SESSION["SessionWert"])){
        if($_SESSION["SessionWert"] != "Admin"){
            header("location: ../checks/UA_access.php");
        }
    }
    else{
        header("location: ../checks/UA_access.php");
    }
?>