<?php 
//Funktionen um JPG und PNG Dateien zu resizen. Original images werden nicht hinterlegt
//Nur die resized Files werden im relevanten uploads Ordner gespeichert  
    function resizeJpeg($bildname, $destimage) {
        //-----Thumbnail machen-----
        $srcimage = $_FILES["Bildupload"]["tmp_name"]; //Pfad vom original
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
        return $destimage; 
    }

    function resizePng($bildname, $destimage) {
        //-----Thumbnail machen-----
        $srcimage = $_FILES["Bildupload"]["tmp_name"]; //Pfad vom original
        list($width, $height) = getimagesize($srcimage);
        $newwidth=720; //Maße, die in den Unterlagen gegeben wurden
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
        return $destimage;
    }
?>
        