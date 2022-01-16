<?php include "head.php"; ?>
<body>
<br><br><br>
    <?php
        require_once('dbaccess.php');
        include "nav.php";
        include "user_indicator.php";
        include "test_input.php"; //use test_input() to call function
        include "resizeImage.php";

        //Checkt die mit POST gesendeten Daten auf unerwünschte Inputs
        $bildname = "";
        $errors = "";
        if (isset($_POST["Bildname"])) {
            $bildname = test_input($_POST["Bildname"])."_".uniqid();
            $errors = checkOnlyCharsAndNumbers($_POST["Bildname"]);
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            switch($path_parts["extension"]){
                case "jpg" : $destimage = resizeJpeg($bildname); break;
                case "png" : $destimage = resizePng($bildname); break;
                default: $error = "Bitte nur JPG oder PNG Files!!!!!";
            }
        }
        ?>
        <br><br><br><br>
        <?php
        //Erstellter News Beitrag wird in die Datenbank hochgeladen 
        //Datum und Uhrezeit werden per Timestamp in der Datenbank eingetragen
        //active State wird per Default auf true gesetzt -> neue News werden also sofort angezeigt 
            if (isset($_POST["newsText"]) && $errors == ""){
            $content = test_input($_POST["newsText"]);
            $headline = test_input($_POST["newsHeadline"]);
            $sql = "INSERT INTO news (content, headline, imgpath, active) VALUES (?, ?, ?, true)";
            $stmt = $db_obj->prepare($sql);
            if ($stmt===false){
                echo($db_obj->error);
            }
            $stmt->bind_param("sss",$content, $headline, $destimage);
            $stmt->execute();
            $stmt->close(); $db_obj->close();
        }
        ?>
    <!--News Beiträge werden erstellt.
        Beitrag besteht aus Titel, Text, Bild, Datum, Uhrzeit
    -->
    <div class="input"> 
    <form enctype="multipart/form-data" action="addNews.php" method = "post">
        Headline:<br>
        <input type="text" name="newsHeadline"><br>
        Write your news here:<br>
        <textarea name="newsText"></textarea><br>
        <span class="error"><?php echo $errors;?></span>
        <label for="Bildname">Picture Title</label><br>
        <input type="text" name="Bildname"><br>
        <input type="file" accept=".jpg, .png" name="Bildupload"><br>
        <input type="submit">

    </form>
    </div>
</body>
</html>