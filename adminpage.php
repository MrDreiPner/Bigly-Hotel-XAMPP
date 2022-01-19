<?php 
    include "head.php"; 
    include ("checks/user_admin_check.php");
?>

<body>
    <?php include "nav.php"; ?>
    <h1 id="header">Hello Admin!</h1>
    <div class="d-grid gap-2 d-md-block" id="admin-links">
        <a class="btn btn-primary" href="user/registrierung.php">Add User</a>
        <a class="btn btn-primary" href="user/userVerwaltung.php">Manage Users</a>
        <a class="btn btn-primary" href="news/addNews.php">Add News</a>
        <a class="btn btn-primary" href="news/newsVerwaltung.php">Manage News</a>
        <a class="btn btn-primary" href="ticket/service.php">New Service-Ticket</a>
        <a class="btn btn-primary" href="ticket/ticketVerwaltung.php">Manage Service-Tickets</a>
    </div>
</body>
</html>

