<?php include "head.php"; ?>
<body >
    <?php
        include "nav.php";
    ?>   
    <div id="image">
        <img id="harold"  class="img-fluid rounded-start" src="Werbebilder/harold1.jpg" alt="Hide the Pain">
    </div>    
<div class="text-wrap text-start" id="help">
    <div id="inner-help">
    <p class="card"><h4>As Anonymous you can:</h4><br>
            <ul class="card-body">
                <li id="help-list">See News</li>
                <li id="help-list">See Help</li>
                <li id="help-list">See Impressum</li>
                <li id="help-list">Log In</li>
            </ul>
            <br>
            To login, click the 'Login' button in the Navbar and enter your credentials.
        </p>
        <p class="card"><h4>As Admin you can:</h4><br>
            <ul class="card-body">
                <li id="help-list">Manage News</li>
                <li id="help-list">Add News</li>
                <li id="help-list">View all users</li>
                <li id="help-list">Register new user (service, guest, admin)</li>
                <li id="help-list">Manage all users (update all users)</li>
                <li id="help-list">Update Admin profile</li>
                <li id="help-list">View all Service-Tickets (Open closed Tickets)</li>
                <li id="help-list">Write new Service-Tickets</li>
                <li id="help-list">Log Out</li>
            </ul>
            <br>
            After login you are redirected to an overview of your options, click the 'Admin Duties' in the Navbar button to return here.<br>
            <h4>Manage News</h4><br>
            To edit news entries, click 'Manage News' -> Now you can see all news entries.<br>
            To add news, click 'Post News' -> add a headline, content and an optional pciture.<br>
            <br>
            <h4>Manage Users</h4><br>
            To see all users, click 'Manage Users' -> Now you can see all active and inactive users.<br>
            To edit a user, click the username -> you can now change all the users informations or delete them.<br>
            To add a user, while in 'Manage Users', click 'Register New User' -> enter their credentials.<br> 
            (Their email address is the users initial username, this can be changed by the user or admin after registration)<br>
            The Admin can update their own Profile by either clicking on 'Profile' in the Navbar or selecting themselves through 'Manage Users'<br>
            <br>
            <h4>Manage Tickets</h4><br>
            To see all service tickets, click 'Service-Tickets' -> Now you can see all open and closed tickets.<br>
            To open a new ticket, click 'Open Service Ticket' -> Enter a Title, your issue and an optional picture.<br>
            To view and re-open guest and admin tickets, click on the Title of the ticket -> if it is closed, you can re-open it.<br>
        </p>
        <p class="card"><h4>As Service you can:</h4><br>
            <ul class="card-body">
            <li id="help-list">View all Service-Tickets</li>
            <li id="help-list">Respond to open Service-Tickets</li>
            <li id="help-list">Close Service Tickets (un/successfully)</li>
            <li id="help-list">Log Out</li>
            </ul>
        <br>
        After login, you get redirected to the ticket management page.<br>
        <h4>Manage Tickets</h4><br>
            To see all service tickets, click 'Service-Tickets' -> Now you can see all open and closed tickets.<br>
            To view, respond and close tickets posted by guests and admins, click on the Title of the ticket -> if it is open, you can respond and close it.<br>
        </p>    
        <p class="card"><h4>As Guest you can:</h4><br>
            <ul class="card-body">
                <li id="help-list">Manage your own Profile</li>
                <li id="help-list">Submit Service-Tickets</li>
                <li id="help-list">See your own Service-Tickets</li>
                <li id="help-list">Re-Open your own closed Service-Tickets</li>
                <li id="help-list">Log Out</li>
            </ul>
            <br>
            After login you are redirected to the main page.<br>
            <h4>Manage Users</h4><br>
            The User can update their own Profile by clicking on 'Profile' in the Navbar. To update their password, the old password needs to be entered<br>
            <br>
            <h4>Manage Tickets</h4><br>
            To see and post service tickets, click 'Services' -> Now you can see all the guests open and closed tickets.<br>
            From here you can also easily open a new ticket -> Enter a Title, your issue and an optional picture.<br>
            To view and re-open the guests tickets, click on the Title of the ticket -> if it is closed, you can re-open it.<br>
        </p>
    </div>
</div>
</body>
</html>

