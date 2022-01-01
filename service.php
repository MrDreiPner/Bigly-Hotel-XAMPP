<?php include "head.php"; ?>
<body>
    <?php 
        include "user_guest_check.php";
        require_once('dbaccess.php');
        include "nav.php";
    ?>
    <br><br> <br><br>
    <div class="input">
    <form enctype="multipart/form-data" method="POST">
        <label for="Betreff" required>Betreff</label><br>
        <span class="error"> <?php if(isset($errors)){ echo $errors;}?></span>
        <input type="text" name="Betreff"><br>
        Please describe the issues:<br>
        <textarea name="serviceText" required></textarea><br><br>
        <span class="error"><?php if(isset($error)){ echo $error;}?></span>
        <input type="file" accept=".jpg, .png"  name="Bildupload"><br>
        <input type="submit">
    </form>
    </div>
    <?php 
        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $bildname = "";
        function checkOnlyCharsAndNumbers($input){
            return preg_match("/^[a-zA-Z0-9_ ]*$/",$input) ? "" : "Keine Sonderzeichen!";
        }

        $errors = "";
        $error = "";
        if (isset($_POST["Betreff"])){
            $errors = checkOnlyCharsAndNumbers($_POST["Betreff"]);
            $betreff = test_input($_POST["Betreff"]);
        }

        if (isset($_FILES["Bildupload"]) && $errors == "") {
            $bildname = "service_". time()."_".uniqid();
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            if (isset($path_parts["extension"]) && ($path_parts["extension"] == "png" || $path_parts["extension"] == "jpg")) {                    
                $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/Bigly-Hotel-XAMPP/uploads/source/" .$bildname.".".$path_parts["extension"];                
                move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
                switch($path_parts["extension"]){
                    case "jpg" : $destimage = resizeJpeg($bildname); break;
                    case "png" : $destimage = resizePng($bildname); break;
                    default: $error = "Bitte nur JPG oder PNG Files!!!!!";
                }
            }
        }
        function resizeJpeg($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "uploads/source/".$bildname.".jpg"; //Pfad vom original
            $destimage = "uploads/service/".$bildname."-thumb.jpg"; //Pfad vom resize
            list($width, $height) = getimagesize($srcimage);
            $newwidth=720;
            $newheight=480;
            //resizing von originalimg wird in thumb hinterlegt
            $originalimg = imagecreatefromjpeg($srcimage);
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled(
                $thumb, $originalimg,
                0, 0, 0, 0,
                $newwidth, $newheight,
                $width, $height
            );
            //speichern des Thumbnails
            imagejpeg($thumb, $destimage);
            echo "gespeichert<br>";
            echo "<img src=$destimage><br>";
            echo "<img src=$srcimage>";    
            return $destimage; 
        }

        function resizePng($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "uploads/source/".$bildname.".png"; //Pfad vom original
            $destimage = "uploads/service/".$bildname."-thumb.png"; //Pfad vom resize
            list($width, $height) = getimagesize($srcimage);
            $newwidth=720;
            $newheight=480;
            //resizing von originalimg wird in thumb hinterlegt
            $originalimg = imagecreatefrompng($srcimage);
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled(
                $thumb, $originalimg,
                0, 0, 0, 0,
                $newwidth, $newheight,
                $width, $height
            );
            //speichern des Thumbnails
            imagepng($thumb, $destimage);
            echo "gespeichert<br>";
            echo "<img src=$destimage><br>";
            echo "<img src=$srcimage>";   
            return $destimage; 
        }
        if (isset($_POST["serviceText"]) && $error == ""){
            $serviceText = test_input($_POST["serviceText"]);
            $u_username = $_SESSION["ID"];
            $sql = "INSERT INTO tickets (betreff, text_guest, image_path, userID, status, resolved) VALUES (?, ?, ?, ?, true, false)";
            $stmt = $db_obj->prepare($sql);
            if ($stmt===false){
                echo($db_obj->error);
            }
            $stmt->bind_param("sssi",$betreff, $serviceText, $destimage, $u_username);
            $stmt->execute();
            $stmt->close(); $db_obj->close();
        }
    ?>
</body>
</html>