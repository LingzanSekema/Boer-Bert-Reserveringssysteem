<?php

$accommodation_types = [
    "caravan" => "Caravan",
    "tent" => "Tent",
    "luxury_tent" => "Luxury tent"
];

?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservering Gelukt</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Reservering Gelukt</h1>
        </div>
    </header>

    <main>
        <section class="content">
            <h2>Bedankt voor je reservering!</h2>
            <p>Hier zijn je gegevens:</p>
            <ul>
                <li><strong>Voornaam:</strong> <?php echo htmlspecialchars($_GET['firstname']); ?></li>
                <li><strong>Achternaam:</strong> <?php echo htmlspecialchars($_GET['lastname']); ?></li>
                <li><strong>Telefoonnummer:</strong> <?php echo htmlspecialchars($_GET['phone']); ?></li>
                <li><strong>E-mail:</strong> <?php echo htmlspecialchars($_GET['email']); ?></li>
                <li><strong>Check-in Datum:</strong> <?php echo htmlspecialchars($_GET['check_in']); ?></li>
                <li><strong>Check-out Datum:</strong> <?php echo htmlspecialchars($_GET['check_out']); ?></li>
                <li><strong>Aantal Personen:</strong> <?php echo htmlspecialchars($_GET['guest_count']); ?></li>
                <li><strong>Accommodatie Type:</strong> <?php echo ($accommodation_types[$_GET['accommodation_type']]); ?></li>
            </ul>
            <p>We kijken ernaar uit je te verwelkomen op Camping De Groene Weide!</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Camping De Groene Weide. Alle rechten voorbehouden.</p>
    </footer>
</body>

</html>