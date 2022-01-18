<?php
        //selektiert die active gesetzten News aus der Datenbank
        $sql = 'select headline, imgpath, content, date from news 
                where active = true
                order by date desc, time desc';
        $stmt = $db_obj->prepare($sql);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($headline, $imgpath, $content, $date);
    ?>
    <ul>
        <?php 
            //Printet die News Beiträge
            while($stmt->fetch()){
                echo "<li><p><h4>". $headline. "</h4>". $date ."<br>"
                 . $content . "<br><div id='image'><img src='". $imgpath ."' alt ='". $headline ."'></div>
                 </p>
                </li>";
            }
            $stmt->close(); $db_obj->close();
        ?>
    </ul>