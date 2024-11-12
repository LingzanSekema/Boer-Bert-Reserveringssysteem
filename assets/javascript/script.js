document.getElementById("reservationForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Voorkomt dat het formulier echt wordt verzonden
    
    // Haal de waarden op uit het formulier
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const date = document.getElementById("date").value;
    
    console.log(email)
    console.log(name)
    console.log(date)

    // Toon het bevestigingsbericht
    const confirmationMessage = document.getElementById("confirmationMessage");
    const reservationDetails = document.getElementById("reservationDetails");
    reservationDetails.innerHTML = `Naam: ${name}<br>E-mail: ${email}<br>Datum: ${date}`;
    
    confirmationMessage.classList.remove("hidden");
    
    // Optioneel: maak het formulier leeg
    document.getElementById("reservationForm").reset();
});
