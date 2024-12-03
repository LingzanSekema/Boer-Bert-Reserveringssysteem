<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'medewerker') {
    // Gebruiker is niet ingelogd, doorverwijzen naar loginpagina
    header('Location: login.php');
    exit();
}


require 'database.php';

$allReserveringen = $conn->query("SELECT * FROM reservering");
$reserveringen = $allReserveringen->fetch_all(MYSQLI_ASSOC);

// Log uit functionaliteit
if (isset($_POST['logout'])) {
    // Verwijder alle sessievariabelen
    session_unset();
    // Vernietig de sessie
    session_destroy();
    // Redirect naar de loginpagina
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

    <h1 class="mb-3 ">Medewerker dashboard</h1>
    <div class="container">

        <div class="row">

            <?php foreach ($reserveringen as $reservering) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                            <div class="card-body" style="background-color: #85C496;">
                            <h5 class="card-title"><?php echo ($reservering["firstname"]) . ' ' . ($reservering["lastname"]); ?></h5>
                            <p class="card-text"><strong>Check in:</strong> <?php echo ($reservering["check_in"]); ?></p>
                            <p class="card-text"><strong>Check out:</strong> <?php echo ($reservering["check_out"]); ?></p>
                            <p class="card-text"><strong>Aantal personen:</strong> <?php echo ($reservering["guest_count"]); ?></p>
                            <p class="card-text"><strong>Accommodatie type:</strong> <?php echo ($reservering["accommodation_type"]); ?></p>
                            <!--knop toevoegen -->
                            <a href="info.php?id=<?php echo $reservering['id']; ?>" class="btn btn-light mt-2">Beheren</a>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<!-- Log uit knop -->
    <form method="POST" action="">
        <button type="submit" name="logout" class="btn btn-danger">Log uit</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>