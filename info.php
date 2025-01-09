<?php
session_start();
require 'database.php';

// Variabele voor een succesbericht
$successMessage = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ID ophalen en omzetten naar een integer voor veiligheid

    // Functie om reserveringsgegevens op te halen
    function getReservation($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM reservering WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Reserveringsgegevens ophalen
    $reservering = getReservation($conn, $id);

    if (!$reservering) {
        echo "Geen reservering gevonden.";
        exit;
    }
} else {
    echo "Geen ID opgegeven.";
    exit;
}

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $check_in = $_POST['check_in']; // Zal niet worden gewijzigd als readonly
    $check_out = $_POST['check_out'];
    $guest_count = intval($_POST['guest_count']);
    $accommodation_type = $_POST['accommodation_type'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Query om de gegevens bij te werken
    $update_stmt = $conn->prepare("UPDATE reservering SET firstname = ?, lastname = ?, check_in = ?, check_out = ?, guest_count = ?, accommodation_type = ?, email = ?, phone = ? WHERE id = ?");
    $update_stmt->bind_param("ssssisssi", $firstname, $lastname, $check_in, $check_out, $guest_count, $accommodation_type, $email, $phone, $id);

    if ($update_stmt->execute()) {
        $successMessage = "De reservering is succesvol bijgewerkt!";
        // Na de update opnieuw reserveringsgegevens ophalen
        $reservering = getReservation($conn, $id);
    } else {
        $successMessage = "Er is een fout opgetreden bij het bijwerken.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Gasten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light" style="height: 100vh;">
    <div class="d-flex justify-content-center align-items-start" style="height: 100%;">
        <div class="card shadow p-4 text-center" style="max-width: 400px; width: 100%; margin-top: 50px;">
            <div class="container d-flex justify-content-start align-items-start mt-3">
                <a href="medewerker_dashboard.php" class="text-dark" style="text-decoration: none; font-size: 1.5rem;">
                    &#8592; <!-- Unicode voor een simpele pijl -->
                </a>
            </div>
            <h1 class="mb-3">Meer info</h1>
            <p class="mb-4">Wijzig gegevens en/of reservering.</p>

            <!-- Succesbericht weergeven -->
            <?php if (!empty($successMessage)) { ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="firstname" class="form-label">Voornaam</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo htmlspecialchars($reservering['firstname']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Achternaam</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo htmlspecialchars($reservering['lastname']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="check_in" class="form-label">Check-in</label>
                    <input
                        type="date"
                        name="check_in"
                        id="check_in"
                        class="form-control"
                        value="<?php echo htmlspecialchars($reservering['check_in']); ?>"
                        <?php if ($reservering['inchecken']) echo 'readonly'; ?>
                        required>
                </div>
                <div class="mb-3">
                    <label for="check_out" class="form-label">Check-out</label>
                    <input
                        type="date"
                        name="check_out"
                        id="check_out"
                        class="form-control"
                        value="<?php echo htmlspecialchars($reservering['check_out']); ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="guest_count" class="form-label">Aantal Personen</label>
                    <input type="number" name="guest_count" id="guest_count" class="form-control" value="<?php echo htmlspecialchars($reservering['guest_count']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="accommodation_type" class="form-label">Accommodatietype</label>
                    <input type="text" name="accommodation_type" id="accommodation_type" class="form-control" value="<?php echo htmlspecialchars($reservering['accommodation_type']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($reservering['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefoon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($reservering['phone']); ?>" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Bijwerken</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');

            // Stel de minimale check-out datum in wanneer de check-in datum verandert
            checkInInput.addEventListener('change', function() {
                const checkInDate = checkInInput.value;
                if (checkInDate) {
                    checkOutInput.min = checkInDate; // Minimale waarde instellen voor check-out
                }
            });

            // Controleer of check-out niet kleiner is dan check-in
            checkOutInput.addEventListener('input', function() {
                const checkInDate = checkInInput.value;
                const checkOutDate = checkOutInput.value;

                if (checkOutDate && checkOutDate < checkInDate) {
                    checkOutInput.setCustomValidity('Check-out datum mag niet eerder zijn dan check-in datum.');
                } else {
                    checkOutInput.setCustomValidity(''); // Reset foutmelding
                }
            });
        });
    </script>
    x

</body>

</html>