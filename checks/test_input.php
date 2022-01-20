<?php 
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function checkOnlyChars($input){
        return preg_match("/^[a-zA-Z]*$/",$input) ? "" : "Nur Buchstaben erlaubt!";
    }

    function checkOnlyNumbers($input){
        return preg_match("/^[0-9]*$/",$input) ? "" : "Nur Zahlen erlaubt!";
    }

    function checkOnlyCharsAndNumbersNoSpace($input){
        return preg_match("/^[a-zA-Z0-9]*$/",$input) ? "" : "Keine Sonderzeichen/ Leerzeichen erlaubt!";
    }

    function checkOnlyCharsAndNumbers($input){
        return preg_match("/^[a-zA-Z0-9_ ]*$/",$input) ? "" : "Keine Sonderzeichen!";
    }

    function checkEmail($input){
        return filter_var($input, FILTER_VALIDATE_EMAIL) ? "" : "Adresse ungültig!";
    }
?>