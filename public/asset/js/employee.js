document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById('employeeForm');
    let firstNameInput = document.getElementById('first_name');
    let formType = document.getElementById('formType').value;
    let lastNameInput = document.getElementById('last_name');
    let companyIdInput = document.getElementById('company_id');
    let emailInput = document.getElementById('email');
    let phoneInput = document.getElementById('phone');

    let firstNameError = document.getElementById('firstNameError');
    let lastNameError = document.getElementById('lastNameError');
    let companyError = document.getElementById('companyError');
    let emailError = document.getElementById('emailError');
    let phoneError = document.getElementById('phoneError');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let valid = validateInputs();
        if (valid) {
            form.submit();
        }
    });

    firstNameInput.addEventListener('input', validateFirstName);
    lastNameInput.addEventListener('input', validateLastName);
    if (formType === 'add') {
        companyIdInput.addEventListener('input', validateCompanyId);
    }
    emailInput.addEventListener('input', validateEmail);
    phoneInput.addEventListener('input', validatePhone);

    function validateInputs() {
        let valid = true;
        if (!validateFirstName()) valid = false;
        if (!validateLastName()) valid = false;
        if (formType === 'add' && !validateCompanyId()) valid = false;
        if (!validateEmail()) valid = false;
        if (!validatePhone()) valid = false;
        return valid;
    }

    function validateFirstName() {
        let firstName = firstNameInput.value.trim();
        firstNameError.textContent = '';

        if (firstName === '') {
            firstNameError.textContent = 'First name is required';
            return false;
        }
        return true;
    }

    function validateLastName() {
        let lastName = lastNameInput.value.trim();
        lastNameError.textContent = '';

        if (lastName === '') {
            lastNameError.textContent = 'Last name is required';
            return false;
        }
        return true;
    }

    function validateCompanyId() {
        let companyId = companyIdInput.value.trim();
        companyError.textContent = '';

        if (companyId === '') {
            if (formType === 'add') {
                companyError.textContent = 'Company is required';
                return false;
            }
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

    function validatePhone() {
        let phone = phoneInput.value.trim();
        phoneError.textContent = '';

        if (phone === '') {
            phoneError.textContent = 'Phone is required';
            return false;
        } else if (!/^\+?[1-9]\d{1,14}$/.test(phone)) {
            phoneError.textContent = 'Invalid phone format';
            return false;
        }
        return true;
    }
});