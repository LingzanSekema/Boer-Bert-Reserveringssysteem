<?php
require "database.php";

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guest_count = $_POST['guest_count'];
    $accommodation_type = $_POST['accommodation_type'];

    $stmt = $conn->prepare("INSERT INTO reservering (firstname, lastname, phone, email, check_in, check_out, guest_count, accommodation_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $firstname, $lastname, $phone, $email, $check_in, $check_out, $guest_count, $accommodation_type);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        // Doorsturen naar bevestigingspagina met gegevens
        header("Location: bevestiging.php?firstname=" . ($firstname) .
            "&lastname=" . ($lastname) .
            "&phone=" . ($phone) .
            "&email=" . ($email) .
            "&check_in=" . ($check_in) .
            "&check_out=" . ($check_out) .
            "&guest_count=" . ($guest_count) .
            "&accommodation_type=" . ($accommodation_type));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}



?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping De Groene Weide</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="header-content">
            <h1><span class="logo">🌿</span> Camping De Groene Weide</h1>
            <p>Beleef de rust en schoonheid van de natuur, bij de boer</p>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Reserveer je verblijf</h2>
            <p>Klik op de knop hieronder om een reservering te maken.</p>
            <br>
            <div class="info-box">
                <p>U hoeft pas te betalen als u bij de receptie bent.<br>
                    Openbare doucheruimtes en toiletten zijn inbegrepen bij de prijs.</p>
            </div>
            <button id="reserveer-knop">Reserveer Nu</button>
        </section>

        <section id="formulier" class="form-popup">
            <form action="reservering.php" method="POST" id="reserveringsformulier">
                <span id="sluit-knop" class="sluit-knop">&times;</span>
                <h2>Reserveringsformulier</h2>

                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" required>

                <label for="phone">Telefoonnummer:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="check_in">Check-in Datum:</label>
                <input type="date" id="check_in" name="check_in" required>

                <label for="check_out">Check-out Datum:</label>
                <input type="date" id="check_out" name="check_out" required>

                <label for="guest_count">Aantal Personen:</label>
                <input type="number" id="guest_count" name="guest_count" min="1" required>

                <label for="accommodation_type">Accommodatie Type:</label>
                <select id="accommodation_type" name="accommodation_type" required>
                    <option value="caravan">Caravan</option>
                    <option value="tent">Tent</option>
                    <option value="luxury_tent">Luxe Tent</option>
                </select>

                <button type="submit" name="submit">Verzenden</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Camping De Groene Weide. Alle rechten voorbehouden.</p>
        <p>Contact: info@degroeneweide.nl | Telefoon: 012-3456789</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>