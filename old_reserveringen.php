<?php
require "database.php";


$sql = "SELECT * FROM reservering ORDER BY firstname ASC, lastname ASC";

$result = mysqli_query($conn, $sql);
$all_reserveringen = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle reserveringen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Stijlen voor de tabel */
        .table th {
            background-color: #85C496;
            color: white;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        /* Stijlen voor de tabel rand */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .table td,
        .table th {
            padding: 12px;
            border: 1px solid #ddd;
        }

        /* Toevoegen van een schaduw aan de tabel */
        .table-container {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .btn-back {
            background-color: rgb(43, 114, 47);
            /* Groene achtergrondkleur */
            color: white;
            font-weight: bold;
            border-radius: 25px;
            /* Ronde hoeken voor de knop */
            padding: 12px 24px;
            /* Ruimte rondom de tekst */
            border: none;
            transition: background-color 0.3s, transform 0.3s;
            /* Toevoegen van overgang voor hover effect */
        }

        .btn-back:hover {
            background-color: #45a049;
            /* Donkerder groen bij hover */
            transform: scale(1.05);
            /* Knop vergroot bij hover */
        }

        .btn-back:focus {
            outline: none;
            /* Verwijder de focus ring bij klikken */
        }
    </style>

</head>

<body>
    <table class="table ">
        <thead>
            <tr>
                <th>voornaam</th>
                <th>Achternaam</th>
                <th>Telefoonnummer</th>
                <th>Email</th>
                <th>Check in</th>
                <th>Check out</th>
                <th>Hoeveel personen</th>
                <th>Accommodatie type</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_reserveringen as $reservering) { ?>
                <tr>
                    <td><?php echo $reservering["firstname"] ?></td>
                    <td><?php echo $reservering["lastname"] ?></td>
                    <td><?php echo $reservering["phone"] ?></td>
                    <td><?php echo $reservering["email"] ?></td>
                    <td><?php echo $reservering["check_in"] ?></td>
                    <td><?php echo $reservering["check_out"] ?></td>
                    <td><?php echo $reservering["guest_count"] ?></td>
                    <td><?php echo $reservering["accommodation_type"] ?></td>


                </tr>


            <?php } ?>
        </tbody>
    </table>

    <div class="text-center mt-3">
        <!-- Aangepaste groene knop -->
        <a href="medewerker_dashboard.php" class="btn btn-back">Terug naar het dashboard</a>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>