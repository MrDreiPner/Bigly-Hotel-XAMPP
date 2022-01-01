<?php include "head.php"; ?>
<body>
    <?php
        require_once('dbaccess.php');
        include "nav.php";

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $bildname = "";
        function checkOnlyCharsAndNumbers($input){
            return preg_match("/^[a-zA-Z0-9_]*$/",$input) ? "" : "Keine Leerzeichen/ Sonderzeichen!";
        }
        $errors = "";
        if (isset($_POST["Bildname"])) {
            $bildname = test_input($_POST["Bildname"])."_".uniqid();
            $errors = checkOnlyCharsAndNumbers($_POST["Bildname"]);
        }
        if (isset($_FILES["Bildupload"]) && $errors == "") {
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            if (isset($path_parts["extension"])) {                    
                $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/Bigly-Hotel-XAMPP/uploads/source/" .$bildname.".".$path_parts["extension"];                
                move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
                switch($path_parts["extension"]){
                    case "jpg" : resizeJpeg($bildname); break;
                    case "png" : resizePng($bildname); break;
                    default: $error = "Bitte nur JPG oder PNG Files!!!!!";
                }
            }
        }
        function resizeJpeg($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "uploads/source/".$bildname.".jpg"; //Pfad vom original
            $destimage = "uploads/news/".$bildname."-thumb.jpg"; //Pfad vom resize
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
        }

        function resizePng($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "uploads/source/".$bildname.".png"; //Pfad vom original
            $destimage = "uploads/news/".$bildname."-thumb.png"; //Pfad vom resize
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
        }
        ?>
        <br><br><br><br>
    <div class="input">
    <form enctype="multipart/form-data" action="addNews.php" method = "post">
        Headline:<br>
        <input type="text" name="newsHeadline"><br>
        Write your news here:<br>
        <textarea name="newsText"></textarea><br>
        <span class="error"><?php echo $errors;?></span>
        <label for="Bildname">Picture Title</label><br>
        <input type="text" name="Bildname"><br>
        <input type="file" name="Bildupload"><br>
        <input type="submit">

    </form>
    </div>
</body>
</html>