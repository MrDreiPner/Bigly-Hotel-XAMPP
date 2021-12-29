<html>
<link rel="stylesheet" href="navstyle.css">
<nav name="navigation">
        <ul>
            <il><a href="index.php">Zur Homepage</a></il> 
            <il><a href="impressum.php">Impressum</a></il>
            <il><a href="hilfe.php">Hilfe</a></il>
            <?php 
            if (isset ($_SESSION["SessionWert"])) {
                echo "<il><a href='logout.php'>Logout</a></il>";
                if ($_SESSION["SessionWert"] == "Admin") {
                    echo "<il><a href='addNews.php'>Neue News</a></il>";
                    echo "<il><a href='registrierung.php'>Registrieren</a></il>";
                }
                if($_SESSION["SessionWert"] != "Guest"){
                    echo "<il><a href='service.php'>Service</a></il>";
                }
            }
            else {
                echo "<il><a href='loginPage.php'>Login</a></il>"; 
            }
            ?>
            
        </ul>
    </nav>
</html>