<?php include "head.php"; ?>
<body>
    <?php
        include "nav.php";
    ?>
    <div id="Header">
        <h1 id="Überschrift">Sie möchten ein Zimmer reservieren?</h1>
    </div>
    <form action="Ticketdata.html" result="GET">
        <div>
        <select>Anrede: <!--Überlegung ob Anrede notwendig bzw wie man Anrede genderneutral angehen kann-->
            <option>Herr</option>
            <option>Frau</option>
            <option>-</option>
        </select>
        </div>
        <br>
        <div>
            <label for="Vorname">Vorname:</label>
            <input type="text" name="Vorname" id="Vorname"><br>
        </div>
        <div>
            <label for="Nachname">Nachname:</label>
            <input type="text" name="Nachname" id="Nachname"><br>
        </div>
        <div>
            <label for="email">E-Mail-Adresse:</label>
            <input type="email" name="email" id="email"><br>
        </div>
        <div class="ersteClass zweiteClass">
            <label for="tel">Tel. Nummer:</label>
            <input type="tel" name="tel" id="tel">
        </div>
        <p class="ersteClass">Adresse:<br>
            <label>Straße:</label>
            <input type="text" id="address"><br>
            <label>Hausnummer:</label>
            <input type="text" id="address"><br>
            <label>Ort:</label>
            <input type="text" id="address"><br>
            <label>PLZ:</label>
            <input type="text" id="address"><br>
        </p>
        <button type="submit">Abschicken</button>
    </form>
</body>
</html>