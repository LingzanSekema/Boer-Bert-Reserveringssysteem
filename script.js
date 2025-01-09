// Haal elementen op voor hergebruik
const reservationForm = document.getElementById("reserveringsformulier");
const reserveerKnop = document.getElementById("reserveer-knop");
const formulierPopup = document.getElementById("formulier");
const checkinInput = document.getElementById("check_in");
const checkoutInput = document.getElementById("check_out");
const phoneInput = document.getElementById("phone");
const guestCountInput = document.getElementById("guest_count");

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

// Controleer of het telefoonnummer een geldig Nederlands nummer is
function isValidDutchPhoneNumber(phone) {
    // Telefoonnummer moet beginnen met '06'
    if (!phone.startsWith("06")) {
        alert("Het telefoonnummer moet beginnen met 06.");
        return false;
    }
    // Telefoonnummer moet precies 10 cijfers bevatten
    if (phone.length !== 10) {
        alert("Het telefoonnummer moet precies 10 cijfers bevatten.");
        return false;
    }
    // Controleer of het telefoonnummer alleen uit cijfers bestaat
    if (isNaN(phone)) {
        alert("Het telefoonnummer mag alleen uit cijfers bestaan.");
        return false;
    }
    return true;
}

// Beperk de invoer van het telefoonnummer tot alleen cijfers en maximaal 10 cijfers
phoneInput.addEventListener("input", function () {
    // Verwijder niet-numerieke tekens
    phoneInput.value = phoneInput.value.replace(/[^0-9]/g, "");

    // Beperk de lengte tot 10 cijfers
    if (phoneInput.value.length > 10) {
        phoneInput.value = phoneInput.value.slice(0, 10);
    }
});

// Klik op het vraagteken voor het tonen/verbergen van de info-box
document.getElementById("email-info-icon-question-mark").addEventListener("click", function () {
    const infoBox = document.getElementById("email-info-box");
    console.log("Info box gevonden:", infoBox); // Dit zorgt ervoor dat we kunnen zien of het element goed geselecteerd wordt

    // Toggle de zichtbaarheid van de info-box
    if (infoBox.style.display === "block") {
        infoBox.style.display = "none"; // Verberg de info-box
    } else {
        infoBox.style.display = "block"; // Toon de info-box
    }
});

// // Klik op het vraagteken voor het tonen/verbergen van de info-box
// document.getElementById("email-info-icon").addEventListener("click", function () {
//     const infoBox = document.getElementById("email-info-box");
//     // Toggle de 'visible' class om de info-box te tonen of te verbergen
//     infoBox.classList.toggle("visible");
//     infoBox.classList.toggle("hidden");
// });

// Controleer of het aantal personen maximaal 8 is
guestCountInput.addEventListener("input", function () {
    if (guestCountInput.value > 8) {
        alert("Het maximale aantal personen is 8.");
        guestCountInput.value = 8; // Stel het maximaal toegestane aantal in
    } else if (guestCountInput.value < 1) {
        guestCountInput.value = 1; // Minimale waarde van 1 persoon
    }
});

// Voeg een eventlistener toe aan het formulier
reservationForm.addEventListener("submit", function (event) {
    const phone = phoneInput.value;
    const checkin = document.getElementById("check_in").value;
    const checkout = document.getElementById("check_out").value;

    // Controleer of de check-out datum na de check-in datum ligt
    if (new Date(checkout) <= new Date(checkin)) {
        alert("De check-out datum moet later zijn dan de check-in datum.");
        event.preventDefault(); // Blokkeer verzending bij fout
        return;
    }

    // Controleer het telefoonnummer
    if (!isValidDutchPhoneNumber(phone)) {
        event.preventDefault(); // Blokkeer verzending bij fout
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