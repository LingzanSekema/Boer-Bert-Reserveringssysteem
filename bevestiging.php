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
    <title>Reservering Bevestiging</title>
    <link rel="stylesheet" href="bevestiging.css">
</head>

<body>
    <div class="body">
        <div class="content">
            <div class="check">
                ✔
            </div>
            <h1 class="header">Bedankt voor uw reservering!</h1>
            <p>Wij hebben uw reservering in goede orde ontvangen. Hieronder vindt u een overzicht van uw gemaakte reservering.</p>

            <div class="overzicht-reservering">
                <table>
                    <tr>
                        <th>Naam:</th>
                        <td><?php echo htmlspecialchars($_GET['firstname'] . ' ' . $_GET['lastname']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($_GET['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Telefoon:</th>
                        <td><?php echo htmlspecialchars($_GET['phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Check-in:</th>
                        <td><?php echo htmlspecialchars($_GET['check_in']); ?></td>
                    </tr>
                    <tr>
                        <th>Check-out:</th>
                        <td><?php echo htmlspecialchars($_GET['check_out']); ?></td>
                    </tr>
                    <tr>
                        <th>Accommodatie:</th>
                        <td><?php echo htmlspecialchars($accommodation_types[$_GET['accommodation_type']]); ?></td>
                    </tr>
                    <tr>
                        <th>Aantal Personen:</th>
                        <td><?php echo htmlspecialchars($_GET['guest_count']); ?></td>
                    </tr>
                </table>
            </div>

            <p class="Wekijkenernauit">We kijken ernaar uit om u te verwelkomen op Camping De Groene Weide!</p>
        </div>
    </div>
</body>

</html>

