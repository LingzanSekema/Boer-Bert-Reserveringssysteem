document.getElementById("reservationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Voorkomt dat het formulier echt wordt verzonden
    
    // Haal de waarden op uit het formulier
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const persons = document.getElementById("persons").value;
    const date = document.getElementById("date").value;
    
    // Valideer het telefoonnummer (moet beginnen met 06 en precies 10 cijfers lang zijn)
    const phoneRegex = /^06\d{8}$/;
    if (!phoneRegex.test(phone)) {
        alert("Voer een geldig Nederlands telefoonnummer in.");
        return; // Stop de functie als het nummer ongeldig is
    }
    
    // Toon het bevestigingsbericht
    const confirmationMessage = document.getElementById("confirmationMessage");
    const reservationDetails = document.getElementById("reservationDetails");
    reservationDetails.innerHTML = `
        Naam: ${name}<br>
        E-mail: ${email}<br>
        Telefoonnummer: ${phone}<br>
        Aantal personen: ${persons}<br>
        Datum: ${date}
    `;
    
    confirmationMessage.classList.remove("hidden");
    
    // Log de gegevens naar de console
    console.log("Reservering gemaakt:");
    console.log("Naam:", name);
    console.log("E-mail:", email);
    console.log("Telefoonnummer:", phone);
    console.log("Aantal personen:", persons);
    console.log("Datum:", date);

    // Optioneel: maak het formulier leeg
    document.getElementById("reservationForm").reset();
});

// Zorg ervoor dat alleen cijfers worden ingevoerd in het telefoonnummerveld
document.getElementById("phone").addEventListener("input", function(event) {
    const input = event.target.value;
    event.target.value = input.replace(/[^0-9]/g, ''); // Vervang niet-cijfertekens door lege tekens
});
