<?php
session_start();
require 'database.php'; // Zorg ervoor dat deze verbinding correct is ingesteld

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL om gebruiker te zoeken op e-mail
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Bind parameters en voer de query uit
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Controleer of gebruiker bestaat
        if ($result && mysqli_num_rows($result) > 0) {
            $data_uit_database = mysqli_fetch_array($result, MYSQLI_ASSOC);

            // Controleer of wachtwoord klopt
            if (password_verify($password, $data_uit_database['password'])) {
                // Sla gegevens op in de sessie
                $_SESSION['email'] = $data_uit_database['email'];
                $_SESSION['role'] = $data_uit_database['role'];

                // Redirect op basis van de rol
                switch ($data_uit_database['role']) {
                    case 'bert':
                        $location = "bert_dashboard.php";
                        break;
                    case 'medewerker':
                        $location = "medewerker_dashboard.php";
                        break;
                    default:
                        $location = "reservering.php";
                        break;
                }

                header("Location: $location");
                exit;
            } else {
                $error = "Onjuist wachtwoord.";
            }
        } else {
            $error = "Gebruiker met dit e-mailadres bestaat niet.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Er is een fout opgetreden bij het voorbereiden van de query.";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="E-mailadres" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit" name="submit">Log in</button>
    </form>

    <?php if (isset($error)) {
        echo "<p style='color:red;'>$error</p>";
    } ?>
</body>

</html>