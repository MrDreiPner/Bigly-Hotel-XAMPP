<?php include "head.php"; ?>
<body>
<br><br><br>
    <?php 
    require_once('dbaccess.php');
    include "nav.php"; 
    ?>
<br><br><br><br>
    <?php
    include "test_input.php"; //use test_input() to call function
        $verification = "Please Log In";
        if (isset($_POST["Username"])) {
            $PW_input = test_input($_POST["Password"]);
            $user_input = test_input($_POST["Username"]);

            $sql = 'select userID, username, password, vorname, role, active from user where username = ?';

            $stmt = $db_obj->prepare($sql);
            $stmt-> bind_param('s', $user_input);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();

            $stmt->bind_result($u_id, $u_username, $u_password, $vorname, $role, $active);
            $stmt->fetch();

            if($active != 1)
            {
                $verification = "Account inactive! Please contact Administrator.";
            }
            else if (password_verify($PW_input, $u_password)) {
                setcookie("CookieWert", $u_username, time()+3600);
                $_SESSION["SessionWert"] = $role;
                $_SESSION["User"] = $u_username;
                $_SESSION["ID"] = $u_id;
                $_SESSION["vorname"] = $vorname;
                $_SESSION['LAST_ACTIVITY'] = time();
            }
            else {
                $verification = "<br>Wrong credentials! Try again!";
            }

            if (isset($_SESSION["SessionWert"])) {
                setcookie("CookieWert", $user_input, time()+3600);
            }
            $stmt->close(); $db_obj->close();
            
        }
        
        if (isset($verification)){
            echo $verification;
        }
        echo "<br>";

        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ", $_SESSION["SessionWert"];
            switch ($_SESSION["SessionWert"]){
                case "Admin": header("location: adminpage.php");
                break;
                case "Service": header("location: ticketVerwaltung.php");
                break;
                case "Guest": header("location: index.php");
                break;
                default: header("location: index.php");
            }
        }
    ?>
    <div id="Header">
        <h1 id="Überschrift">User Log In</h1>
    </div>
    <form enctype="multipart/form-data" action="loginPage.php" method="POST">
        <label for="Username">Username</label>
        <input type="text" name="Username" required placeholder="Username" value="<?php echo isset($_COOKIE["CookieWert"]) ? $_COOKIE["CookieWert"] : "";?>"><br>
        <label for="Password">Password</label>
        <input type="password" required name="Password"><br>
        <input type="submit">
    </form>

    </body>
</html>