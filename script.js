// Haal elementen op voor hergebruik
const reservationForm = document.getElementById("reserveringsformulier");
const reserveerKnop = document.getElementById("reserveer-knop");
const formulierPopup = document.getElementById("formulier");
const checkinInput = document.getElementById("check_in");
const checkoutInput = document.getElementById("check_out");
const phoneInput = document.getElementById("phone");

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

// Stel de minimale datum in bij het laden van de pagina
setMinDate();
