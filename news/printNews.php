<?php
        //selektiert die active gesetzten News aus der Datenbank

        $sql = 'select news_id, headline, imgpath, content, date from news 
                where active = true
                order by date desc, time desc';
        $stmt = $db_obj->prepare($sql);
        if ($stmt===false){
            echo($db_obj->error);
            echo "fail";
        }
        $stmt->execute();
        $stmt->bind_result($id, $headline, $imgpath, $content, $date);
    ?>
    <ul>
        <?php 
            //Printet die News Beiträge
            while($stmt->fetch()){
                echo "<li class='card mb-3' id='news-card'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <img src='".$imgpath."' class='img-fluid rounded-start' alt='".$headline."'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body' id='news-text'>
                            <h4 class='card-title'>".$headline."</h4>
                            <p class='card-text'>".$content."</p>
                            <p class='card-text'><small class='text-muted'>".$date."</small></p>
                            <a id='news-button' href='news/showNews.php?news_id=".$id."' class='btn btn-primary'>Read more</a>
                        </div>
                    </div>
                </div>
            </li>";
            }
            $stmt->close(); $db_obj->close();
        ?>
    </ul>