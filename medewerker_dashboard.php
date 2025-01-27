<?php
session_start();


// Controleer of de gebruiker is ingelogd en de juiste rol heeft
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'medewerker') {
    header('Location: login.php');
    exit();
}

require 'database.php';

// Inchecken functionaliteit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_in'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE reservering SET inchecken = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: medewerker_dashboard.php");
    exit();
}

// Uitchecken functionaliteit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_out'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("UPDATE reservering SET uitchecken = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: medewerker_dashboard.php");
    exit();
}

// Haal reserveringen op die nog niet zijn uitgecheckt
$query = "SELECT * FROM reservering WHERE uitchecken = 0 OR uitchecken IS NULL ORDER BY check_in ASC";
$result = $conn->query($query);
$reserveringen = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <style>
        body {
            background-color: #f4f7fa;
        }

        h1 {
            color: rgb(43, 126, 47);
            ;
            /* Groene kleur voor de titel */
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            background-color: #85C496; /* Frisse groene kleur voor de body van de kaart */
            color: black;
            background-color: #85C496;
            /* Frisse groene kleur voor de body van de kaart */
            color: white;
            border-radius: 10px;
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        .logout-btn {
            position: sticky;
            top: 10px;
            left: 10px;
            background-color: #e74c3c;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
            z-index: 1000;
            /* Zorg dat de knop altijd boven andere elementen staat */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .logout-btn:focus {
            outline: none;
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
        background-color: #85C496; /* lichtgroen voor de navbar */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtiele schaduw */
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

    .navbar{
        margin-bottom: 30px;
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
        <a class="navbar-brand text-white" href="index.html">
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

  


    <h1 class="mb-3 text-center">Reserveringen</h1>
    <div class="container">
        <div class="row">
            <?php if (!empty($reserveringen)) { ?>
                <?php foreach ($reserveringen as $reservering) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body" style="background-color: #85C496;">
                                <h5 class="card-title">
                                    <?php echo htmlspecialchars($reservering["firstname"] . ' ' . $reservering["lastname"]); ?>
                                </h5>
                                <p class="card-text"><strong>Check in:</strong> <?php echo htmlspecialchars($reservering["check_in"]); ?></p>
                                <p class="card-text"><strong>Check out:</strong> <?php echo htmlspecialchars($reservering["check_out"]); ?></p>
                                <p class="card-text"><strong>Aantal personen:</strong> <?php echo htmlspecialchars($reservering["guest_count"]); ?></p>
                                <p class="card-text"><strong>Accommodatie type:</strong> <?php echo htmlspecialchars($reservering["accommodation_type"]); ?></p>

                                <!-- Inchecken knop -->
                                <?php if (!$reservering['inchecken']) { ?>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservering['id']); ?>">
                                        <button type="submit" name="check_in" class="btn btn-back">Inchecken</button>
                                    </form>
                                <?php } else { ?>
                                    <p class="text-success">Ingecheckt ✅</p>

                                    <!-- Uitchecken knop -->
                                    <?php if (!$reservering['uitchecken']) { ?>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservering['id']); ?>">
                                            <button type="submit" name="check_out" class="btn btn-success">Uitchecken</button>
                                        </form>
                                    <?php } ?>
                                <?php } ?>

                                <!-- Beheren knop -->
                                <a href="info.php?id=<?php echo $reservering['id']; ?>" class="btn btn-light mt-2">Bewerken</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-center">Geen actieve reserveringen gevonden.</p>
            <?php } ?>
        </div>
    </div>


    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>