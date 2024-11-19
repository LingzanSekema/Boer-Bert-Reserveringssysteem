// Haal elementen op voor hergebruik
const reservationForm = document.getElementById("reservationForm");
const confirmationMessage = document.getElementById("confirmationMessage");
const backToFormButton = document.getElementById("backToForm");
const checkinInput = document.getElementById("checkin");
const checkoutInput = document.getElementById("checkout");

// Stel de minimale datums in voor check-in en check-out velden
function setMinDate() {
    const today = new Date().toISOString().split("T")[0];
    checkinInput.min = today;
    checkoutInput.min = today;
}

// Update de minimale waarde van de check-out datum zodra de check-in datum wordt gewijzigd
checkinInput.addEventListener("change", function() {
    const checkinDate = new Date(checkinInput.value);
    checkinDate.setDate(checkinDate.getDate() + 1); // Minimaal één dag na check-in
    checkoutInput.min = checkinDate.toISOString().split("T")[0];
});

// Voeg een eventlistener toe aan het formulier
reservationForm.addEventListener("submit", function(event) {
    event.preventDefault(); // Voorkomt dat het formulier echt wordt verzonden
    
    // Haal de waarden op uit het formulier
    const phone = document.getElementById("phone").value;
    const checkin = document.getElementById("checkin").value;
    const checkout = document.getElementById("checkout").value;
    const sanitary = document.getElementById("sanitary").value;
    
    // Valideer het telefoonnummer (moet beginnen met 06 en precies 10 cijfers lang zijn)
    // const phoneRegex = /^06\d{8}$/;
    // if (!phoneRegex.test(phone)) {
    //     alert("Voer een geldig Nederlands mobiel nummer in dat begint met 06 en 10 cijfers bevat.");
    //     return;
    // }
    
    // Controleer of de check-out datum na de check-in datum ligt
    if (new Date(checkout) <= new Date(checkin)) {
        alert("De check-out datum moet later zijn dan de check-in datum.");
        return;
    }

    // Verberg het formulier en toon het bevestigingsbericht
    reservationForm.classList.add("hidden");
    confirmationMessage.classList.remove("hidden");
    
    // Optioneel: maak het formulier leeg
    reservationForm.reset();
    setMinDate(); // Reset ook de minimale datums
});

// Voeg een eventlistener toe aan de "Terug naar formulier"-knop
backToFormButton.addEventListener("click", function() {
    // Toon het formulier en verberg het bevestigingsbericht
    reservationForm.classList.remove("hidden");
    confirmationMessage.classList.add("hidden");
});
    
// Zorg ervoor dat alleen cijfers worden ingevoerd in het telefoonnummerveld
// document.getElementById("phone").addEventListener("input", function(event) {
//     const input = event.target.value;
//     event.target.value = input.replace(/[^0-9]/g, ''); // Vervang niet-cijfertekens door lege tekens
// });

// Stel de minimale datum in bij het laden van de pagina
setMinDate();
