<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'bert') {
    // Gebruiker is niet ingelogd, doorverwijzen naar loginpagina
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Dashboard Boer Bert</h1>
</body>

</html>