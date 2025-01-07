<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'medewerker') {
    header('Location: login.php');
    exit();
}

require 'database.php';

// Inchecken functionaliteit
if (isset($_POST['check_in'])) {
    $id = $_POST['id'];
    $conn->query("UPDATE reservering SET inchecken = 1 WHERE id = $id");
    header("Location: medewerker_dashboard.php");
    exit();
}

// Uitchecken functionaliteit
if (isset($_POST['check_out'])) {
    $id = $_POST['id'];
    $conn->query("UPDATE reservering SET uitchecken = 1 WHERE id = $id");
    header("Location: medewerker_dashboard.php");
    exit();
}

// Query: Haal alleen reserveringen op die niet zijn uitgecheckt
$allReserveringen = $conn->query("
    SELECT * FROM reservering 
    WHERE uitchecken = 0 OR uitchecken IS NULL 
    ORDER BY check_in ASC
");

$reserveringen = $allReserveringen->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <h1 class="mb-3 text-center">Reserveringen</h1>
    <div class="container">
        <div class="row">
            <?php foreach ($reserveringen as $reservering) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body" style="background-color: #85C496;">
                            <h5 class="card-title"><?php echo htmlspecialchars($reservering["firstname"] . ' ' . $reservering["lastname"]); ?></h5>
                            <p class="card-text"><strong>Check in:</strong> <?php echo htmlspecialchars($reservering["check_in"]); ?></p>
                            <p class="card-text"><strong>Check out:</strong> <?php echo htmlspecialchars($reservering["check_out"]); ?></p>
                            <p class="card-text"><strong>Aantal personen:</strong> <?php echo htmlspecialchars($reservering["guest_count"]); ?></p>
                            <p class="card-text"><strong>Accommodatie type:</strong> <?php echo htmlspecialchars($reservering["accommodation_type"]); ?></p>

                            <!-- Inchecken knop -->
                            <?php if (!$reservering['inchecken']) { ?>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservering['id']); ?>">
                                    <button type="submit" name="check_in" class="btn btn-success">Inchecken</button>
                                </form>
                            <?php } else { ?>
                                <p class="text-success">Ingecheckt ✅</p>

                                <!-- Uitchecken knop -->
                                <?php if (!$reservering['uitchecken']) { ?>
                                    <form method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservering['id']); ?>">
                                        <button type="submit" name="check_out" class="btn btn-warning">Uitchecken</button>
                                    </form>
                                <?php } ?>
                            <?php } ?>

                            <!-- Beheren knop -->
                            <a href="info.php?id=<?php echo $reservering['id']; ?>" class="btn btn-light mt-2">Beheren</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <a href="old_reserveringen.php">Alle reserveringen</a>
    <!-- Log uit knop -->
    <form method="POST" class="text-center mt-3">
        <button type="submit" name="logout" class="btn btn-danger">Log uit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>