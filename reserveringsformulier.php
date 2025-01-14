<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserveringsformulier</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <h1><span class="logo">🌿</span> Camping De Groene Weide</h1>
            <p>Beleef de rust en schoonheid van de natuur, bij de boer</p>
        </div>
    </header>

    <main>
        <section id="formulier">
            <form action="reservering.php" method="POST" id="reserveringsformulier">
                <h2>Reserveringsformulier</h2>
            
                <label for="firstname">Voornaam:</label>
                <input type="text" id="firstname" name="firstname" placeholder="Bijv. Jan" required>
            
                <label for="lastname">Achternaam:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Bijv. Jansen" required>
            
                <label for="phone">Telefoonnummer:</label>
                <input type="text" id="phone" name="phone" placeholder="Bijv. 0612345678" required>
            
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" placeholder="Bijv. jan.jansen@email.com" required>
            
                <label for="check_in">Check-in Datum:</label>
                <input type="text" id="check_in" name="check_in" placeholder="Selecteer een datum" readonly required>
            
                <label for="check_out">Check-out Datum:</label>
                <input type="text" id="check_out" name="check_out" placeholder="Selecteer een datum" readonly required>
            
                <label for="guest_count">Aantal Personen:</label>
                <input type="number" id="guest_count" name="guest_count" min="1" placeholder="Bijv. 2" required>
            
                <label for="accommodation_type">Accommodatie Type:</label>
                <select id="accommodation_type" name="accommodation_type" required>
                    <option value="" disabled selected>Kies een optie</option>
                    <option value="caravan">Caravan</option>
                    <option value="tent">Tent</option>
                    <option value="luxury_tent">Luxe Tent</option>
                </select>
            
                <button type="submit" name="submit">Verzenden</button>
            </form>            
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Camping De Groene Weide. Alle rechten voorbehouden.</p>
        <p>Contact: info@degroeneweide.nl | Telefoon: 06-12345678</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Incheck datum picker
            const checkIn = flatpickr("#check_in", {
                dateFormat: "Y-m-d",
                minDate: "today", // Voorkom dat een datum in het verleden wordt geselecteerd
                onChange: function (selectedDates, dateStr) {
                    // Pas de minimale datum van check-out aan
                    checkOut.set("minDate", dateStr);
                },
            });

            // Uitcheck datum picker
            const checkOut = flatpickr("#check_out", {
                dateFormat: "Y-m-d",
                minDate: "today", // Voorkom dat een datum in het verleden wordt geselecteerd
                onChange: function (selectedDates, dateStr) {
                    // Controleer of de check-out datum na check-in datum is
                    const checkInDate = document.querySelector("#check_in").value;
                    if (new Date(dateStr) <= new Date(checkInDate)) {
                        alert("De check-out datum moet na de check-in datum zijn.");
                        checkOut.clear(); // Maak het veld leeg als het ongeldig is
                    }
                },
            });
        });
    </script>
</body>
</html>
