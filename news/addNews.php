<?php include ("../head.php"); ?>
<body>
<br><br><br>
    <?php
        require_once('../dbaccess.php');
        include ("../nav.php");
        include ("../checks/user_admin_check.php");
        include ("../checks/test_input.php"); //use test_input() to call function
        include ("../resizeImage.php");

        //Checkt die mit POST gesendeten Daten auf unerwünschte Inputs
        $bildname = "";
        $errors = "";
        if (isset($_POST["Bildname"]) && isset($_FILES["Bildupload"])) {
            $bildname = test_input($_POST["Bildname"])."_".uniqid();
            $errors = checkOnlyCharsAndNumbersNoSpace($_POST["Bildname"]);
            $path_parts = pathinfo($_FILES["Bildupload"]["name"]);
            ;
            if (isset($path_parts["extension"]))
            {
                switch($path_parts["extension"]){
                    case "jpg" :
                        $destimage = "../uploads/news/".$bildname."-thumb.jpg"; 
                        $destimage = resizeJpeg($bildname, $destimage); break;
                    case "png" :
                        $destimage = "../uploads/news/".$bildname."-thumb.png"; 
                        $destimage = resizePng($bildname, $destimage); break;
                    default: $error = "Bitte nur JPG oder PNG Files!!!!!";
                }
            }
        }
        ?>
        <br><br><br>
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
    <div id="form">
        <div id="inner-form">
            <h1 id="Überschrift">Add News Post</h1><br>
            <form enctype="multipart/form-data" action="addNews.php" method = "post">
                <div class="mb-3">
                    <label class="form-label" for="newsHeadline">Headline</label>
                    <input type="text" class="form-control" required name="newsHeadline">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="newsText">Write your news here</label>
                    <textarea name="newsText" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="Bildname">Picture Title</label>      
                    <span class="error"><?php echo $errors;?></span> 
                    <input type="text" class="form-control" name="Bildname"><br>
                    <input type="file" id="img-upload" accept=".jpg, .png" name="Bildupload" class="btn btn-primary btn-sm form-control">
                </div>
                <input type="submit" id="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</body>
</html>