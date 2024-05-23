
document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById('companyForm');
    let formType = document.getElementById('formType').value;
    let nameInput = document.getElementById('name');
    let emailInput = document.getElementById('email');
    let logoInput = document.getElementById('logo');
    let websiteInput = document.getElementById('website');

    let nameError = document.getElementById('nameError');
    let emailError = document.getElementById('emailError');
    let logoError = document.getElementById('logoError');
    let websiteError = document.getElementById('websiteError');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let valid = validateInputs();
        if (valid) {
            form.submit();
        }
    });
    nameInput.addEventListener('input', validateName);
    emailInput.addEventListener('input', validateEmail);
    logoInput.addEventListener('input', validateLogo);
    websiteInput.addEventListener('input', validateWebsite);

    function validateInputs() {
        let valid = true;
        if (!validateName()) valid = false;
        if (!validateEmail()) valid = false;
        if (formType === 'add' && !validateLogo()) valid = false;
        if (!validateWebsite()) valid = false;
        return valid;
    }

    function validateName() {
        let name = nameInput.value.trim();
        nameError.textContent = '';

        if (name === '') {
            nameError.textContent = 'Name is required';
            return false;
        }
        return true;
    }

    function validateEmail() {
        let email = emailInput.value.trim();
        emailError.textContent = '';

        if (email === '') {
            emailError.textContent = 'Email is required';
            return false;
        } else if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email)) {
            emailError.textContent = 'Invalid email format';
            return false;
        }
        return true;
    }

    function validateLogo() {
        let logo = logoInput.value.trim();
        logoError.textContent = '';

        if (logo === '') {
            if (formType === 'add') {
                logoError.textContent = 'Logo is required';
                return false;
            }
        } else if (!/(\.jpg|\.jpeg|\.png)$/i.test(logo)) {
            logoError.textContent = 'Only jpg, jpeg, png files are allowed';
            return false;
        }
        return true;
    }


    function validateWebsite() {
        let website = websiteInput.value.trim();
        websiteError.textContent = '';

        if (website === '') {
            websiteError.textContent = 'Website is required';
            return false;
        } else if (!/^(https?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w-._~:\/?#\[\]@!$&'()*+,;=]*)?$/.test(website)) {
            websiteError.textContent = 'Invalid website format';
            return false;
        }
        return true;
    }
});

