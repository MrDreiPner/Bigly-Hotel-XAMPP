<link rel="stylesheet" href="style.css">
<nav class="navbar-header">    
    <nav name="navigation"  class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">BIGLY HOTEL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"></a></a></li>
        <?php 
        //Jeder User sieht nur die Links, die für ihn relevant sind bzw für die er Berechtigungen hat
            if (isset ($_SESSION["SessionWert"])) {
                if ($_SESSION["SessionWert"] == "Admin") {
                    echo "<li class='nav-item'><a class='nav-link' href='adminpage.php'>Admin Duties</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='newsVerwaltung.php'>Manage News</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='userverwaltung.php'>Manage Users</a></li>";
                }
                if ($_SESSION["SessionWert"] == "Service" || $_SESSION["SessionWert"] == "Admin") {
                    echo "<li class='nav-item'><a class='nav-link' href='ticketVerwaltung.php'>Service-Tickets</a></li>";
                }
                if ($_SESSION["SessionWert"] == "Guest" || $_SESSION["SessionWert"] == "Admin") {
                    if($_SESSION["SessionWert"] != "Admin"){
                        echo "<li class='nav-item'><a class='nav-link' href='service.php'>Service</a></li>";
                    }
                    echo "<li class='nav-item'><a class='nav-link' href='manageUser.php'>Profile</a></li>";
                }
                echo "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout</a></li>";
            } 
            else {
                echo "<li class='nav-item'><a class='nav-link' href='loginPage.php'>Login</a></li>";
            }
        ?>
                    <li class="nav-item"><a class="nav-link" href="hilfe.php">Help</a></li>
                    <li class="nav-item"><a class="nav-link" href="impressum.php">Impressum</a></li>
                    <li class="nav-item"><a class="nav-link disabled"></a></li>
                </ul>
            </div>
        </div>
    </nav>
</nav>