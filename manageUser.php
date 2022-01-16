<?php include "head.php"; ?>
<body>
<br><br><br><br><br>
    <?php 
        include "user_guest_check.php";
        require_once('dbaccess.php');
        include "nav.php";
        include "user_indicator.php";
    ?>
    <?php
        if (isset($_SESSION["ID"])){
            $sql = 'select username, email, room 
                    from user
                    where userid = ?';
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_SESSION["ID"]);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->bind_result($username, $email, $room);
            $stmt->fetch();
            $_SESSION["user"] = $username;
            $stmt->close();
        }

        include "test_input.php"; //use test_input() to call function
        function checkEmail($input){
            return filter_var($input, FILTER_VALIDATE_EMAIL) ? "" : "Adresse ungültig!";
        }
        function checkOnlyChars($input){
            return preg_match("/^[a-zA-Z]*$/",$input) ? "" : "Nur Buchstaben erlaubt!";
        }

        function checkOnlyNumbers($input){
            return preg_match("/^[0-9]*$/",$input) ? "" : "Nur Zahlen erlaubt!";
        }

        function checkOnlyCharsAndNumbers($input){
            return preg_match("/^[a-zA-Z0-9]*$/",$input) ? "" : "Keine Sonderzeichen erlaubt!";
        }

        $checkschecked = "Profile updated!";
        $errors = array();


        if(isset($_POST["delete"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = $_GET["user_to_manage_ID"];
            $sql = "delete 
                   from user 
                   where user_id = ?";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $ID);
            if ($stmt===false){
            echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close(); $db_obj->close();
            header("Refresh:0; url=userVerwaltung.php");
        }

        if(isset($_POST["ch_username"])){
            $ch_username = test_input($_POST["ch_username"]);
            $errors["ch_username"] = checkOnlyCharsAndNumbers($ch_username);
            $sql = "SELECT username FROM user WHERE username = '$ch_username'"; 
            $result = $db_obj->query($sql); 
            $count = mysqli_num_rows($result); 
            if ($count >= 1){ 
                $errors["ch_username"] = "This username is already used!"; 
            }
            $result->close();
            if($errors["ch_username"] == "" && $ch_username != "")
            {
            if(isset($_GET["user_to_manage_ID"]) && $_SESSION["user"] == "Admin")
            {
                $ID = $_GET["user_to_manage_ID"];
                $sql = "update user 
                    set username = ?
                    where userID = $ID";
            }
            else{
                $ID = $_SESSION["ID"];
                $sql = "update user 
                    set username = ?
                    where userID = $ID";
            }
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('s', $ch_username);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
            }
        }
        
        
        if((isset($_POST["ch_pw"]) && !isset($_POST["ch_pw_c"])) || (!isset($_POST["ch_pw"]) && isset($_POST["ch_pw_c"])))
        {
            $errors["ch_pw"] = $errors["ch_pw_c"] = "Incomplete Data!";
        }
        else if(isset($_POST["ch_pw"]) && isset($_POST["ch_pw_c"])){
            $ch_password = test_input($_POST["ch_pw"]);
            $ch_password_c = test_input($_POST["ch_pw_c"]);
            if($ch_password != $ch_password_c)
            {
                $errors["ch_pw"] = $errors["ch_pw_c"] = "Passwords don't match!";
            }
        else
            {
            if($ch_password != "")
            {
                if(isset($_GET["user_to_manage_ID"]) && $_SESSION["user"] == "Admin")
                {
                    $ID = $_GET["user_to_manage_ID"];
                    $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                    $sql = "update user 
                        set password = ?,
                        pw_notiz = ?
                        where userID = $ID";
                }
                else{
                    $ID = $_SESSION["ID"];
                    $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                    $sql = "update user 
                        set password = ?,
                        pw_notiz = ?
                        where userID = $ID";
                }
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('ss', $ch_password, $ch_password_c);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
            }
        }

        if(isset($_POST["ch_email"]) && $_POST["ch_email"] != ""){
            $ch_email = test_input($_POST["ch_email"]);
            $errors["email"] = checkEmail($ch_email);
            if($errors["email"] == "" && $ch_email != "")
            {
                if(isset($_GET["user_to_manage_ID"]) && $_SESSION["user"] == "Admin")
                {
                    $ID = $_GET["user_to_manage_ID"];
                    $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                    $sql = "update user 
                        set email = ?
                        where userID = $ID";
                }
                else
                {
                    $ID = $_SESSION["ID"];
                    $ch_password = password_hash($ch_password, PASSWORD_DEFAULT);
                    $sql = "update user 
                        set email = ?
                        where userID = $ID";
                }
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('s', $ch_email);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();     
            }
        }

        if(isset($_POST["ch_vorname"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $vorname = test_input($_POST["ch_vorname"]);
            $errors["ch_vorname"] = checkOnlyChars($vorname);
            if($errors["ch_vorname"] == "" && $vorname != "")
            {
                $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set vorname = ?
                    where userID = $ID";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('s', $vorname);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $_SESSION["vorname"] = $vorname;
                $stmt->close();
            }
        }

        if(isset($_POST["ch_nachname"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $nachname = test_input($_POST["ch_nachname"]);
            $errors["ch_nachname"] = checkOnlyChars($nachname);
            if($errors["ch_nachname"] == "" && $nachname != "")
            {
                $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set nachname = ?
                    where userID = $ID";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('s', $nachname);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST["ch_room"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $room = test_input($_POST["ch_room"]);
            $errors["ch_room"] = checkOnlyNumbers($room);
            if($errors["ch_room"] == "" && $room != "")
            {
                $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
                $sql = "update user 
                    set room = ?
                    where userID = $ID";
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param('i', $room);
                if ($stmt===false){
                    echo($db_obj->error);
                    echo "fail";
                }
                $stmt->execute();
                $stmt->close();
            }
        }

        if(isset($_POST["anrede"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set anrede = ?
                where userID = $ID";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_POST["anrede"]);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST["role"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set role = ?
                where userID = $ID";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_POST["role"]);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }

        if(isset($_POST["active"]) && $_SESSION["SessionWert"] == "Admin")
        {
            $ID = isset($_GET["user_to_manage_ID"])?$_GET["user_to_manage_ID"] : $_SESSION["ID"];
            $sql = "update user 
                set active = ?
                where userID = $ID";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param('i', $_POST["active"]);
            if ($stmt===false){
                echo($db_obj->error);
                echo "fail";
            }
            $stmt->execute();
            $stmt->close();
        }

        foreach ($errors as $error) {
            if ($error != "") {
                $checkschecked = "Profile NOT updated! Faulty input!";
                setcookie("NotUpdated", 1, time()+1);
            }
        }

        if(isset($_POST["sent"]))
        {
            header("Refresh:0 , url=manageUser.php");
            $db_obj->close();
        }

        if($checkschecked == "Profile updated!" && isset($_POST["sent"])){
            echo $checkschecked;
        }
    ?>
    <h1>Manage Profile</h1>
    <br><br><br><br>
    <div class="input">
        Username: <?php echo $username;?><br>
        E-Mail: <?php echo $email;?><br>
        Room: <?php echo $room;?><br>
    </div>
    <br><br>
    <div class="input">
    <form method="POST" action="manageUser.php">
        <h3>Update Data</h3>
        <label for="ch_username" required>Change username: </label><br>
        <span class="error"> <?php if(isset($errors["ch_username"])){ echo $errors["ch_username"];}?></span>
        <input type="text" name="ch_username"><br>
        <label for="ch_pw" required>Change password: </label><br>
        <span class="error"> <?php if(isset($errors["ch_pw"])){ echo $errors["ch_pw"];}?></span>
        <input type="text" name="ch_pw"><br>
        <label for="ch_pw_c" required>Confirm password: </label><br>
        <span class="error"> <?php if(isset($errors["ch_pw_c"])){ echo $errors["ch_pw_c"];}?></span>
        <input type="text" name="ch_pw_c"><br>
        <label for="ch_email" required>Change E-Mail: </label><br>
        <span class="error"> <?php if(isset($errors["email"])){ echo $errors["email"];}?></span>
        <input type="email" name="ch_email"><br>
        <?php
            if($_SESSION["SessionWert"] == "Admin")
            {
                echo 
                "<label for='ch_vorname' required>First Name: </label><br>
                <span class='error'>"; 
                if(isset($errors["ch_vorname"])){ echo $errors["ch_vorname"];} 
                echo 
                "</span><input type='text' name='ch_vorname'><br>
                <label for='ch_nachname' required>Last Name: </label><br>
                <span class='error'>"; 
                if(isset($errors["ch_nachname"])){ echo $errors["ch_nachname"];} 
                echo 
                "</span><input type='text' name='ch_nachname'><br>
                <label for='ch_room' required>Room: </label><br>
                <span class='error'>"; 
                if(isset($errors["ch_room"])){ echo $errors["ch_room"];} 
                echo 
                "</span><input type='text' name='ch_room'><br>
                <div class='ersteClass'>
                Gender:<br>
                <input name='anrede' type='radio' value=1>Male
                <input name='anrede' type='radio' value=2>Female
                <input name='anrede' type='radio' value=3>Non-Binary
                <input name='anrede' type='radio' value=4>NA<br>
                </div>
                <div class='ersteClass'>
                Role:
                <br>
                <input name='role' type='radio' value=2>Service
                <input name='role' type='radio' value=3>Guest<br>
                </div>
                <div class='ersteClass'>
                Active:
                <br>
                <input name='active' type='radio' value=1>Active
                <input name='active' type='radio' value=0>Inactive<br>
                </div>
                <div class='ersteClass'>
                Delete User:
                <br>
                <input name='delete' type='checkbox' value=1>DELETE<br>
                </div>";
            }
        ?>
        <input type ='hidden' name ='sent' value = '1'/>
        <input type="submit" value="Update">
    </form>
    <?php
        if(isset($_COOKIE["NotUpdated"]))
        {
             echo "Profile NOT updated!";
        }
    if($_SESSION["SessionWert"] == "Admin")
    {
        echo "<form action='userVerwaltung.php'><input type='submit' value='Back'></form>";
    }
    else
    {
        echo "<form action='index.php'><input type='submit' value='Back'></form>";
    }
    ?>
    </div>

</body>
</html>