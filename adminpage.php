<?php 
    include "head.php"; 
    include "user_admin_check.php";
    include "user_indicator.php";
?>

<body>
    <?php include "nav.php"; ?>
    <h1 id="header">Hello Admin!</h1>
    <div class="d-grid gap-2 d-md-block" id="admin-links">
        <a class="btn btn-primary" href="registrierung.php">Add User</a>
        <a class="btn btn-primary" href="userVerwaltung.php">Manage Users</a>
        <a class="btn btn-primary" href="addNews.php">Add News</a>
        <a class="btn btn-primary" href="newsVerwaltung.php">Manage News</a>
        <a class="btn btn-primary" href="ticketVerwaltung.php">Ticket Verwaltung</a>
        <a class="btn btn-primary" href="manageUser.php">Admin Profile</a>
    </div>
</body>
</html>

