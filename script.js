document.getElementById('reserveer-knop').addEventListener('click', function() {
    document.getElementById('formulier').style.display = 'block';
});

document.getElementById('annuleer-knop').addEventListener('click', function() {
    document.getElementById('formulier').style.display = 'none';
});

document.getElementById('reserveringsformulier').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Bedankt voor je reservering!');
    document.getElementById('formulier').style.display = 'none';
});