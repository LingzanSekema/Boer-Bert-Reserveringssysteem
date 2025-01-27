<?php
require "database.php";


$sql = "SELECT * FROM reservering ORDER BY check_out DESC";

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
            border-radius: 8px;
            padding: 20px;
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


        .bg-green {
        background-color: #85C496; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtiele schaduw */
    }

    .navbar{
        margin-bottom: 30px;
    }
    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
    }

    .nav-link {
        font-weight: bold;
        padding: 10px 15px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-link:hover {
        background-color: #45a049; /* Lichtere groene kleur bij hover */
        color: white;
        border-radius: 5px;
    }

    .btn-danger {
        background-color: #e74c3c; /* Rode knop */
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c0392b; /* Donkerdere rode kleur bij hover */
    }

    .text-white {
        color: white !important;
    }

    .navbar-toggler {
        border: none; /* Verwijder de rand rond de toggle-knop */
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=UTF8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%280, 0, 0, 0.5%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        /* Zorg dat de drie streepjes wit zijn */
    }
    </style>

</head>

<body>


<nav class="navbar navbar-expand-lg navbar-light bg-green">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">
            <span class="logo">🌿</span> Camping De Groene Weide
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="medewerker_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="old_reserveringen.php">Reserveringen</a>
                </li>
            </ul>
            <form method="POST" action="logout.php" class="d-flex">
                <button type="submit" name="logout" class="btn btn-danger">Log uit</button>
            </form>
        </div>
    </div>
</nav>

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

   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>