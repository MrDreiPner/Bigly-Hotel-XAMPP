<?php include "head.php"; ?>
<body>
    <?php 
    require_once('dbaccess.php');
    include "nav.php"; 
    ?>
    <?php
    include "test_input.php"; //use test_input() to call function
        $verification = "";
        if (isset($_POST["Username"])) {
            $PW_input = test_input($_POST["Password"]);
            $user_input = test_input($_POST["Username"]);
            //selektiert den Datensatz der zum eingegebenen Username passt. Username ist unique
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
            $stmt->close(); 
            //Es wird geprüft ob es den User in der DB gibt
            $sql = "SELECT username FROM user WHERE username = '$u_username'"; 
            $result = $db_obj->query($sql); 
            $count = mysqli_num_rows($result); 
            $result->close(); $db_obj->close();
            if ($count == 0)
            {
                $verification = "Wrong credentials! Try again!";
            }
            //gleicht das eingegebene Passwort mit dem hinterlegten gehashten Passwort ab 
            else if (password_verify($PW_input, $u_password)) {
                if($active != 1)
                {
                    $verification = "Account inactive! Please contact Administrator!";
                }
                else{
                setcookie("CookieWert", $u_username, time()+3600);
                $_SESSION["SessionWert"] = $role;
                $_SESSION["User"] = $u_username;
                $_SESSION["ID"] = $u_id;
                $_SESSION["vorname"] = $vorname;
                $_SESSION['LAST_ACTIVITY'] = time();
                }
            }
            //Wenn das PW nicht übereinstimmt, wird diese message ausgegeben
            else 
            {
                $verification = "Wrong credentials! Try again!";
            }
            //Der Cookie zum tracken der inactivity wird gesetzt
            if (isset($_SESSION["SessionWert"])) {
                setcookie("CookieWert", $user_input, time()+3600);
            }
            
        }
        
        if (isset($verification)){
            echo $verification;
        }
        echo "<br>";

        //Der neu eingeloggte User wird auf eine andere Seite verlinkt, je nachdem welche Rolle er hat
        //Admins werden auf adminpage verlinkt, die ihnen schnell Zugang zu ihren Hauptaufgaben verschafft
        //Servicetechniker werden direkt zur Ticketverwaltung gelinkt, da das für sie der wichtigste Bereich ist
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
    <div id="login-form">
        <div id="inner-login">
            <h1 id="Überschrift">User Log In</h1><br>
            <span class="error"> <?php echo $verification;?></span> 
            <form enctype="multipart/form-data" action="loginPage.php" method="POST">
                <div id="mb-3">
                    <label class="form-label" for="Username">Username</label>
                    <input type="text" class="form-control" name="Username" required placeholder="Username" value="<?php echo isset($_COOKIE["CookieWert"]) ? $_COOKIE["CookieWert"] : "";?>"><br>
                </div>
                <div id="mb-3">    
                    <label class="form-label" for="Password">Password</label>
                    <input type="password" class="form-control" required name="Password"><br>
                </div>    
                <input type="submit" id="submit" class="btn btn-primary"> 
            </form>
        </div>
    </div>
    </body>
</html>