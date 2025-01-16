// Haal elementen op voor hergebruik
const reservationForm = document.getElementById("reserveringsformulier");
// const reserveerKnop = document.getElementById("reserveer-knop");
const formulierPopup = document.getElementById("formulier");
const checkinInput = document.getElementById("check_in");
const checkoutInput = document.getElementById("check_out");
const guestCountInput = document.getElementById("guest_count");
const phoneInputField = document.getElementById("phone");

// Stel de minimale datums in voor check-in en check-out velden
function setMinDate() {
    const today = new Date().toISOString().split("T")[0];
    checkinInput.min = today;
    checkoutInput.min = today;
}

// Update de minimale waarde van de check-out datum zodra de check-in datum wordt gewijzigd
checkinInput.addEventListener("change", function () {
    const checkinDate = new Date(checkinInput.value);
    checkinDate.setDate(checkinDate.getDate() + 1); // Minimaal één dag na check-in
    checkoutInput.min = checkinDate.toISOString().split("T")[0];
});

// Instellen van Flatpickr voor Check-in en Check-out velden
flatpickr("#check_in", {
    dateFormat: "Y-m-d", // Stel de datumweergave in
    minDate: "today", // De eerste selecteerbare datum is vandaag
    onChange: function (selectedDates, dateStr, instance) {
        // Update de minimale check-out datum op basis van de geselecteerde check-in datum
        const checkOutField = document.querySelector("#check_out");
        const nextDay = new Date(selectedDates[0]);
        nextDay.setDate(nextDay.getDate() + 1); // Voeg 1 dag toe
        checkOutField._flatpickr.set("minDate", nextDay); // Update Flatpickr-instelling
    },
});

flatpickr("#check_out", {
    dateFormat: "Y-m-d", // Stel de datumweergave in
    minDate: "today", // Start altijd vanaf vandaag
});

// Controleer of het aantal personen maximaal 8 is
guestCountInput.addEventListener("input", function () {
    if (guestCountInput.value > 8) {
        alert("Het maximale aantal personen is 8.");
        guestCountInput.value = 8; // Stel het maximaal toegestane aantal in
    } else if (guestCountInput.value < 1) {
        guestCountInput.value = 1; // Minimale waarde van 1 persoon
    }
});

// Functie om mobiele nummervalidatie te controleren op basis van land
function isValidMobileNumber(countryCode, phoneNumber) {
    const mobileNumberPatterns = {
        "+31": /^(6|06)[0-9]{8}$/, // Nederland: moet beginnen met 06 of 6 en 10 cijfers in totaal
        "+44": /^7[0-9]{9}$/,     // Verenigd Koninkrijk: moet beginnen met 7 en 10 cijfers in totaal
        "+1": /^([2-9][0-9]{2})[2-9][0-9]{2}[0-9]{4}$/, // VS/Canada: valideer mobiel
        "+49": /^1[5-7][0-9]{8}$/, // Duitsland: mobiel begint met 15, 16 of 17
        // Voeg meer landen toe indien nodig
    };

    const pattern = mobileNumberPatterns[countryCode];
    if (!pattern) {
        alert("Geen specifieke mobiele validatie beschikbaar voor dit land.");
        return true; // Geen specifieke validatie, accepteer nummer
    }

    return pattern.test(phoneNumber);
}

// Beperk invoer tot alleen cijfers in het telefoonnummer veld
phoneInputField.addEventListener("input", function () {
    phoneInputField.value = phoneInputField.value.replace(/[^0-9]/g, "");
});

// Voeg een eventlistener toe aan het formulier
reservationForm.addEventListener("submit", function (event) {
    const phoneInput = phoneInputField.value;
    const countryCode = document.getElementById("country-code").value;
    const checkin = document.getElementById("check_in").value;
    const checkout = document.getElementById("check_out").value;

    // Controleer of de check-out datum na de check-in datum ligt
    if (new Date(checkout) <= new Date(checkin)) {
        alert("De check-out datum moet later zijn dan de check-in datum.");
        event.preventDefault(); // Blokkeer verzending bij fout
        return;
    }

    // Controleer of het telefoonnummer geldig is voor het geselecteerde land
    if (!isValidMobileNumber(countryCode, phoneInput)) {
        alert("Voer een geldig mobiel telefoonnummer in voor het geselecteerde land.");
        event.preventDefault();
        return;
    }

    // Sluit het formulier en ververs de pagina na succesvolle verzending
    formulierPopup.style.display = "none";
    setTimeout(() => {
        location.reload(); // Ververs de pagina na een korte pauze
    }, 100);
});

// Toon het formulier bij klikken op "Reserveer Nu"
reserveerKnop.addEventListener("click", function () {
    formulierPopup.style.display = "block";
    setMinDate(); // Stel de juiste minimale datums in bij openen
});

// Sluit formulier bij klikken op het kruisje
document.getElementById('sluit-knop').addEventListener('click', function() {
    document.getElementById('formulier').style.display = 'none';
});

// Stel de minimale datum in bij het laden van de pagina
setMinDate();
