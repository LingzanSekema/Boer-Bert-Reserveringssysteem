<?php
require "database.php";


$sql = "SELECT * FROM reservering";

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

</head>

<body>
    <table class="table ">
        <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Check in</th>
                <th>Check out</th>
                <th>Guest count</th>
                <th>Accommidation type</th>

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
    <a href="medewerker_dashboard.php">Terug naar het dashboard</a>

</body>

</html>