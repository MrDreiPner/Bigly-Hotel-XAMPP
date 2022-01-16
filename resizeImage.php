<?php 
        
    function resizeJpeg($bildname) {
        //-----Thumbnail machen-----
        $srcimage = $_FILES["Bildupload"]["tmp_name"]; //Pfad vom original
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
        echo "Saved successfully<br>";
        return $destimage; 
    }

    function resizePng($bildname) {
        //-----Thumbnail machen-----
        $srcimage = $bildname.".png"; //Pfad vom original
        $destimage = "uploads/news/".$bildname."-thumb.png"; //Pfad vom resize
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
        echo "Saved successfully<br>";    
        return $destimage;
    }
?>
        