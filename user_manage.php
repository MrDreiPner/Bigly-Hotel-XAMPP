<?php include "head.php"; ?>
<body>
<br><br><br><br><br>
    <?php 
        include "user_guest_check.php";
        require_once('dbaccess.php');
        include "nav.php";
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
        foreach ($errors as $error)
        {
            $errors[$error] = "";
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
        }
        if((isset($_POST["ch_pw"]) && !isset($_POST["ch_pw_c"])) || (!isset($_POST["ch_pw"]) && isset($_POST["ch_pw_c"])))
        {
            $errors["ch_pw"] = $errors["ch_pw_c"] = "Incomplete Data!";
        }
        if(isset($_POST["ch_pw"]) && isset($_POST["ch_pw_c"])){
            if($data["ch_pw"] != $data["ch_pw_c"])
            {
                
            }
        }
        if(isset($_POST["ch_username"])){
            
        }
        if(isset($_POST["email"])){
            $ch_email = test_input($_POST["email"]);
            $errors["email"] = checkEmail($ch_mail);
        }

        foreach ($errors as $error) {
            if ($error != "") {
                $checkschecked = "Profile NOT updated! Faulty input!";
            }
        }
    
        if($checkschecked == "Profile updated!"){

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
    <form method="POST" action="user_manage.php">
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
        <input type="submit" value="Update">
    </form>
    </div>

</body>
</html>