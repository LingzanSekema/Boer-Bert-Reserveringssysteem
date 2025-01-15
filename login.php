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
    <style>
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(239, 243, 242),rgb(116, 255, 192));
        }

        .login-container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #2d3436;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #636e72;
            text-align: left;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .login-container input:focus {
            border-color:rgb(9, 227, 96);
            box-shadow: 0 0 8px rgba(7, 84, 41, 0.82);
            outline: none;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background:rgb(9, 137, 30);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .login-container button:hover {
            background:rgb(19, 185, 46);
        }

        .login-container p {
            margin-top: 15px;
            font-size: 14px;
        }

        .login-container p a {
            color:rgb(231, 235, 238);
            text-decoration: none;
            font-weight: 600;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        .error {
            color: #d63031;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($error)) { ?>
            <div class="error"> <?php echo $error; ?> </div>
        <?php } ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="E-mailadres" required>
            <input type="password" name="password" placeholder="Wachtwoord" required>
            <button type="submit" name="submit">Log in</button>
        </form>

        <?php if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        } ?>
    </div>
</body>

</html>
