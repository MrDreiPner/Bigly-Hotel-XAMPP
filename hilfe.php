<?php include "head.php"; ?>
<body>

    <?php
        include "nav.php";
        include "user_indicator.php";
    ?>
<div class="fc">
    <div id="Header">
        <h1>Do you need support?</h1>  
    </div>      
    <div id="harold">
        <img src="Werbebilder/harold1.jpg" alt="Hide the Pain" id="haroldbild"> 
    </div>     

    <div class="input">
        Login information:<br>
        <table id="table">
            <tr>
                <th>Role</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
            <tr>
                <td>Admin</td>
                <td>admin</td>
                <td>admin</td>
            </tr>
            <tr>
                <td>Service</td>
                <td>Service1</td>
                <td>service123</td>
            </tr>
            <tr>
                <td>Guest</td>
                <td>Guest1</td>
                <td>guest123</td>
            </tr>
        </table>
    </div>
</div>
<div class="input">
    <p> As Admin you can: <br>
    <ul>
        <li>Manage News</li>
        <li>Add News</li>
        <li>Register new user (service, guest, admin)</li>
        <li>View all users</li>
        <li>Manage all users (update all users)</li>
        <li>Update Admin profile</li>
        <li>View all Service-Tickets (Open closed Tickets)</li>
        <li>Write new Service-Tickets</li>
        <li>Manage all users</li>
        <li>Log Out</li>
    </ul></p>
    <p> As Service you can: <br>
    <ul>
        <li>View all Service-Tickets</li>
        <li>Respond to open Service-Tickets</li>
        <li>Close Service Tickets (un/successfully)</li>
        <li>Log Out</li>
    </ul></p>
    <p> As Guest you can: <br>
    <ul>
        <li>Manage your own Profile</li>
        <li>Submit Service-Tickets</li>
        <li>See their own Service-Tickets</li>
        <li>Re-Open their own closed Service-Tickets</li>
        <li>Log Out</li>
    </ul></p>
    <p> As Anonymous you can: <br>
    <ul>
        <li>See News</li>
        <li>See Help</li>
        <li>See Impressum</li>
        <li>Log In</li>
    </ul></p>
</div>

</body>
</html>