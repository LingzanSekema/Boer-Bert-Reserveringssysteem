// Haal elementen op
const reservationForm = document.getElementById("reserveringsformulier");
const reserveerKnop = document.getElementById("reserveer-knop");
const formulierPopup = document.getElementById("formulier");
const sluitKnop = document.getElementById("sluit-knop");
const checkinInput = document.getElementById("check_in");
const checkoutInput = document.getElementById("check_out");
const phoneInput = document.getElementById("phone");

// Controleer of alle benodigde elementen bestaan
if (reserveerKnop && formulierPopup && sluitKnop) {
    // Toon het formulier bij klikken op "Reserveer Nu"
    reserveerKnop.addEventListener("click", function () {
        formulierPopup.style.display = "block";
        setMinDate(); // Stel de juiste minimale datums in bij openen
    });

    // Verberg het formulier bij klikken op het sluit-kruisje
    sluitKnop.addEventListener("click", function () {
        formulierPopup.style.display = "none";
    });
}

// Stel de minimale datums in voor check-in en check-out velden
function setMinDate() {
    const today = new Date().toISOString().split("T")[0];
    if (checkinInput && checkoutInput) {
        checkinInput.min = today;
        checkoutInput.min = today;
    }
}

// Update de minimale waarde van de check-out datum zodra de check-in datum wordt gewijzigd
if (checkinInput) {
    checkinInput.addEventListener("change", function () {
        const checkinDate = new Date(checkinInput.value);
        checkinDate.setDate(checkinDate.getDate() + 1); // Minimaal één dag na check-in
        if (checkoutInput) {
            checkoutInput.min = checkinDate.toISOString().split("T")[0];
        }
    });
}

// Controleer of het telefoonnummer een geldig Nederlands nummer is
function isValidDutchPhoneNumber(phone) {
    if (!phone.startsWith("06")) {
        alert("Het telefoonnummer moet beginnen met 06.");
        return false;
    }
    if (phone.length !== 10) {
        alert("Het telefoonnummer moet precies 10 cijfers bevatten.");
        return false;
    }
    if (isNaN(phone)) {
        alert("Het telefoonnummer mag alleen uit cijfers bestaan.");
        return false;
    }
    return true;
}

// Beperk de invoer van het telefoonnummer tot alleen cijfers en maximaal 10 cijfers
if (phoneInput) {
    phoneInput.addEventListener("input", function () {
        phoneInput.value = phoneInput.value.replace(/[^0-9]/g, "");
        if (phoneInput.value.length > 10) {
            phoneInput.value = phoneInput.value.slice(0, 10);
        }
    });
}

// Voeg een eventlistener toe aan het formulier
if (reservationForm) {
    reservationForm.addEventListener("submit", function (event) {
        const phone = phoneInput.value;
        const checkin = checkinInput.value;
        const checkout = checkoutInput.value;

        if (new Date(checkout) <= new Date(checkin)) {
            alert("De check-out datum moet later zijn dan de check-in datum.");
            event.preventDefault();
            return;
        }

        if (!isValidDutchPhoneNumber(phone)) {
            event.preventDefault();
            return;
        }
    });
}

// Stel de minimale datum in bij het laden van de pagina
setMinDate();