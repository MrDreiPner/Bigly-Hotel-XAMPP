<?php include "head.php"; ?>
<body>
    <?php 
    require_once('dbaccess.php');
    include "nav.php"; ?>
<br><br><br><br>
    <?php
    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
        if (isset($_POST["Username"])) {
            $PW_input = test_input($_POST["Password"]);
            $user_input = test_input($_POST["Username"]);

            $sql = "select username, password, role from user where username = ? and password = ?";

            $stmt = $db_obj->prepare($sql);
            $stmt-> bind_param("ss", $user_input, $PW_input);
            $stmt->execute();
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $u_username = ""; $u_password = ""; $role = "";
            $stmt->bind_result($u_username, $u_password, $role);
            $stmt->fetch();

            if($u_username == "" || $u_password == "" || $role == ""){
                $verification = "Wrong credentials! Try again!";
            }
            echo "<br>" . $u_username. $u_password. $role . "<br>";

            if (($user_input == $u_username) && ($PW_input == $u_password)) {
                setcookie("CookieWert", $u_username, time()+3600);
                $_SESSION["SessionWert"] = $role;
            }

            if (isset($_SESSION["SessionWert"])) {
                setcookie("CookieWert", $user_input, time()+3600);
                $verification = "Please Log In";
            }
            $stmt->close(); $db_obj->close();
            
        }
        
        if (isset($verification)){
            echo $verification;
        }
        if (isset($_COOKIE["CookieWert"])){
            echo "<br>Cookie: ", $_COOKIE["CookieWert"];
        }
        echo "<br>";

        if (isset($_SESSION["SessionWert"])){
            echo "<br>Session: ", $_SESSION["SessionWert"];
            header("location: index.php");
        }
    ?>

    <form enctype="multipart/form-data" action="loginPage.php" method="POST">
        <label for="Username">Username</label>
        <input type="text" name="Username" required placeholder="Username" value="<?php echo isset($_COOKIE["CookieWert"]) ? $_COOKIE["CookieWert"] : "";?>"><br>
        <label for="Password">Password</label>
        <input type="password" required name="Password"><br>
        <input type="submit">
    </form>

    </body>
</html>