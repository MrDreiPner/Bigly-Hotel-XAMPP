<?php include "head.php"; ?>
<body>
    <h1>Hallo PHP</h1>
    <?php
      require_once ('dbaccess.php');

      if(isset($_POST["vorname"])){
        $sql = "INSERT INTO user (Vorname, Nachname, password) VALUES (?, ?, ?)";
        $stmt = $db_obj->prepare($sql);

        if ($stmt==false){
          echo($db_obj->error);
        }

        $vorname= $_POST["vorname"];
        $nachname = $_POST["nachname"];
        $passwort = $_POST["passwort"];
  
        $stmt->bind_param("sss", $vorname, $nachname, $passwort);
        $stmt->execute();

        /*$vorname= $_POST["vorname"] . "zusätzlich";
        $nachname = $_POST["nachname"] . "zusätzlich";
        $stmt->execute();*/
      }
      $stmt->close(); $db_obj->close();
      header("location: testysendy.php")
    ?>
  </body>
</html>