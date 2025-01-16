<?php

// Start de sessie
session_start();

// Controleer of een sessie actief is
if (session_status() === PHP_SESSION_ACTIVE) {
    // Vernietig alle sessiegegevens
    session_unset();
    session_destroy();
}

// Redirect naar de loginpagina
header("Location: login.php"); // Verander dit naar je eigen loginpagina
exit;
?>
