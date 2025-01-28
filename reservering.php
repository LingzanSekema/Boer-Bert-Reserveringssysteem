<?php
require "database.php";

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guest_count = $_POST['guest_count'];
    $accommodation_type = $_POST['accommodation_type'];

    $stmt = $conn->prepare("INSERT INTO reservering (firstname, lastname, phone, email, check_in, check_out, guest_count, accommodation_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $firstname, $lastname, $phone, $email, $check_in, $check_out, $guest_count, $accommodation_type);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        // Doorsturen naar bevestigingspagina met gegevens
        header("Location: bevestiging.php?firstname=" . ($firstname) .
            "&lastname=" . ($lastname) .
            "&phone=" . ($phone) .
            "&email=" . ($email) .
            "&check_in=" . ($check_in) .
            "&check_out=" . ($check_out) .
            "&guest_count=" . ($guest_count) .
            "&accommodation_type=" . ($accommodation_type));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}