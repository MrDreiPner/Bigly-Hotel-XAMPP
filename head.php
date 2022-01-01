<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Akronim&family=Lato:ital,wght@1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <?php 
        session_start(); 
        if (isset($_SESSION['LAST_ACTIVITY'])) {
            if(time() - $_SESSION['LAST_ACTIVITY'] > 1800){
            session_unset(); 
            session_destroy();
            }
            header("Refresh: 1801 ; url=index.php");
        }
        if (isset($_SESSION['SessionWert'])){
            $_SESSION['LAST_ACTIVITY'] = time();
        }
    ?>

</head>