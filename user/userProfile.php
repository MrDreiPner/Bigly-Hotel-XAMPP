<?php include ("../head.php"); ?>
<body>
<br><br><br><br><br>
    <?php 
        include ("../checks/user_guest_check.php");
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/test_input.php");//test_input() nutzen um rohe Daten zu testen, für mehr siehe test_input.php
    ?>