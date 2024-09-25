function validateForm() {
    // Tarkista sähköposti
    const email = document.getElementById('email').value;
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Anna kelvollinen sähköpostiosoite.");
        return false;
    }

    // Tarkista salasana
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const passwordStrength = document.getElementById('passwordStrength');

    if (password.length < 8) {
        passwordStrength.textContent = "Salasanan tulee olla vähintään 8 merkkiä pitkä.";
        return false;
    }

    if (!/[A-Z]/.test(password)) {
        passwordStrength.textContent = "Salasanan tulee sisältää vähintään yksi iso kirjain.";
        return false;
    }

    if (!/[a-z]/.test(password)) {
        passwordStrength.textContent = "Salasanan tulee sisältää vähintään yksi pieni kirjain.";
        return false;
    }

    if (!/[0-9]/.test(password)) {
        passwordStrength.textContent = "Salasanan tulee sisältää vähintään yksi numero.";
        return false;
    }

    if (password !== confirmPassword) {
        alert("Salasanat eivät täsmää.");
        return false;
    }

    return true;
}