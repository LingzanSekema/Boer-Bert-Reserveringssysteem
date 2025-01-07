<?php
session_start();
require 'database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ID ophalen en omzetten naar een integer voor veiligheid

    // Query om de specifieke klantgegevens op te halen
    $stmt = $conn->prepare("SELECT * FROM reservering WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservering = $result->fetch_assoc();

    if (!$reservering) {
        echo "Geen reservering gevonden.";
        exit;
    }
} else {
    echo "Geen ID opgegeven.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Gasten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <body class="bg-light" style="height: 100vh;">



        <!-- Flex container voor horizontaal centreren, maar bovenaan -->
        <div class="d-flex justify-content-center align-items-start" style="height: 100%;">
            <!-- Card container voor inhoud -->
            <div class="card shadow p-4 text-center" style="max-width: 400px; width: 100%; margin-top: 50px;">

                <div class="container d-flex justify-content-start align-items-start mt-3">
                    <!-- Knop met een pijl naar links -->
                    <button class="btn btn-light">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                </div>
                <!-- <a href="dashboard.php" class="btn btn-dark">Terug naar Dashboard</a>  -->

                <h1 class="mb-3">Incheckpagina</h1>
                <p class="mb-4">Controleer en check gasten in of uit.</p>

                <div class="container mt-5">
                    <h1>Details van de gast</h1>
                    <p><strong>Naam:</strong> <?php echo htmlspecialchars($reservering['firstname'] . ' ' . $reservering['lastname']); ?></p>
                    <p><strong>Check-in:</strong> <?php echo htmlspecialchars($reservering['check_in']); ?></p>
                    <p><strong>Check-out:</strong> <?php echo htmlspecialchars($reservering['check_out']); ?></p>
                    <p><strong>Aantal Personen:</strong> <?php echo htmlspecialchars($reservering['guest_count']); ?></p>
                    <p><strong>Accommodatietype:</strong> <?php echo htmlspecialchars($reservering['accommodation_type']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($reservering['email']); ?></p>
                    <p><strong>Telefoon:</strong> <?php echo htmlspecialchars($reservering['phone']); ?></p>
                </div>
    </body>



</html>