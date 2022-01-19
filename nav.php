<link rel="stylesheet" href="style.css">
<nav class="navbar-header">    
    <nav name="navigation"  class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/webtech/Bigly-Hotel-XAMPP/main/index.php">BIGLY HOTEL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" aria-current="page"></a></a></li>
        <?php 
            include ("user_indicator.php");
        //Jeder User sieht nur die Links, die für ihn relevant sind bzw für die er Berechtigungen hat
            if (isset ($_SESSION["SessionWert"])) {
                if ($_SESSION["SessionWert"] == "Admin") {
                    echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/adminpage.php'>Admin Duties</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/news/newsVerwaltung.php'>Manage News</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/user/userverwaltung.php'>Manage Users</a></li>";
                }
                if ($_SESSION["SessionWert"] == "Service" || $_SESSION["SessionWert"] == "Admin") {
                    echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/ticket/ticketVerwaltung.php'>Service-Tickets</a></li>";
                }
                if ($_SESSION["SessionWert"] == "Guest" || $_SESSION["SessionWert"] == "Admin") {
                    if($_SESSION["SessionWert"] != "Admin"){
                        echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/ticket/service.php'>Service</a></li>";
                    }
                    echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/user/userProfile.php'>Profile</a></li>";
                }
                echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/user/logout.php'>Logout</a></li>";
            } 
            else {
                echo "<li class='nav-item'><a class='nav-link' href='/webtech/Bigly-Hotel-XAMPP/user/loginPage.php'>Login</a></li>";
            }
        ?>
                    <li class="nav-item"><a class="nav-link" href="/webtech/Bigly-Hotel-XAMPP/hilfe.php">Help</a></li>
                    <li class="nav-item"><a class="nav-link" href="/webtech/Bigly-Hotel-XAMPP/impressum.php">Impressum</a></li>
                    <li class="nav-item"><a class="nav-link disabled"></a></li>
                </ul>
            </div>
        </div>
    </nav>
</nav>