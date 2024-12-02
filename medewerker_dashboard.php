<?php
require 'database.php';


$allReserveringen = $conn->query("SELECT * FROM reservering");
$reserveringen = $allReserveringen->fetch_all(MYSQLI_ASSOC);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>medewerker dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <h1 class="mb-3 ">medewerker dashboard</h1>

    <table class="table table-sm">
        <thead>
            <tr>
                <th>Id</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Telefoonnummer</th>
                <th>Email</th>
                <th>Check in</th>
                <th>Check out</th>
                <th>Hoeveelheid gasten</th>
                <th>Accommodatie type</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($reserveringen as $reservering) { ?>
                <tr>
                    <td><?php echo $reservering["id"] ?></td>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>





</html>