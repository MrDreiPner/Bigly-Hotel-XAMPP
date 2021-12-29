<?php include "head.php"; ?>
<body>
    <?php 
    //DB connection needed
    include "nav.php"; ?>
    <br><br> <br><br>
    <?php 
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
                $destination =$_SERVER["DOCUMENT_ROOT"]."/WebTech/Bigly Hotel XAMPP/personen/" .$bildname.".".$path_parts["extension"];                
                move_uploaded_file($_FILES["Bildupload"]["tmp_name"], $destination);
                switch($path_parts["extension"]){
                    case "jpg" : resizeJpeg($bildname); break;
                    case "png" : resizePng($bildname); break;
                    case "gif" : resizeGif($bildname); break;
                    default: $error = "Bitte nur JPG oder PNG Files!!!!!";
                }

            }
        }
        function resizeJpeg($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "personen/".$bildname.".jpg"; //Pfad vom original
            $destimage = "thumbnails/".$bildname."-thumb.jpg"; //Pfad vom resize
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
            $srcimage = "personen/".$bildname.".png"; //Pfad vom original
            $destimage = "thumbnails/".$bildname."-thumb.png"; //Pfad vom resize
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

        function resizeGif($bildname) {
            //-----Thumbnail machen-----
            $srcimage = "personen/".$bildname.".gif"; //Pfad vom original
            $destimage = "thumbnails/".$bildname."-thumb.gif"; //Pfad vom resize
            list($width, $height) = getimagesize($srcimage);
            $newwidth=720;
            $newheight=480;
            //resizing von originalimg wird in thumb hinterlegt
            $originalimg = imagecreatefromgif($srcimage);
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled(
                $thumb, $originalimg,
                0, 0, 0, 0,
                $newwidth, $newheight,
                $width, $height
            );
            //speichern des Thumbnails
            imagegif($thumb, $destimage);
            echo "gespeichert<br>";
            echo "<img src=$destimage><br>";
            echo "<img src=$srcimage>";    
        }
    ?>
    <br><br><br><br>
    <form enctype="multipart/form-data" action="service.php" method="POST">
        <input type="text" placeholder="Why U need help?"><br>
        <span class="error"><?php echo $errors;?></span>
        <label for="Bildname">Bild Titel</label><br>
        <input type="text" name="Bildname"><br>
        <input type="file" name="Bildupload"><br>
        <input type="submit">
    </form><br><br>
    <h2>Dis U?</h2>
</body>
</html>