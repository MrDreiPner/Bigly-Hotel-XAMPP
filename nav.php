<html>
<link rel="stylesheet" href="navstyle.css">
<nav name="navigation">
        <ul>
            <il><a href="index.php">Zur Homepage</a></il> 
            <?php 
            if (isset ($_SESSION["SessionWert"])) {
                if ($_SESSION["SessionWert"] == "Admin") {
                    echo "<il><a href='addNews.php'>Neue News</a></il>";
                    echo "<il><a href='registrierung.php'>Registrieren</a></il>";
                    echo "<il><a href='adminpage.php'>Admin Page</a></il>";
                }
                if ($_SESSION["SessionWert"] == "Guest" || $_SESSION["SessionWert"] == "Admin") {
                    echo "<il><a href='service.php'>Service</a></il>";
                    echo "<il><a href='manageUser.php'>Profile</a></il>";
                }
                if ($_SESSION["SessionWert"] == "Service" || $_SESSION["SessionWert"] == "Admin") {
                    echo "<il><a href='ticketVerwaltung.php'>Service-Tickets</a></il>";
                }
                echo "<il><a href='logout.php'>Logout</a></il>";
            }
            else {
                echo "<il><a href='loginPage.php'>Login</a></il>"; 
            }
            ?>
            <il><a href="impressum.php">Impressum</a></il>
            <il><a href="hilfe.php">Hilfe</a></il>
            
        </ul>
    </nav>
</html>