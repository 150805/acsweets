document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Reset all error messages
    resetErrors();
    
    // Validate all fields
    const isNameValid = validateName();
    const isEmailValid = validateEmail();
    const isPhoneValid = validatePhone();
    const isAgeValid = validateAge();
    const isPasswordValid = validatePassword();
    const isConfirmPasswordValid = validateConfirmPassword();
    const isAccountTypeValid = validateAccountType();
    
    // If all validations pass
    if (isNameValid && isEmailValid && isPhoneValid && isAgeValid && 
        isPasswordValid && isConfirmPasswordValid && isAccountTypeValid) {
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('successMessage').style.display = 'block';
        document.getElementById('successMessage').textContent = 'Form submitted successfully!';
        
        // Clear the form
        clearForm();
        
        // Here you would typically submit the form to a server
        // For now, we'll just log the values
        console.log('Form submitted successfully!');
        
        // Hide the success message after 3 seconds
        setTimeout(() => {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    } else {
        document.getElementById('errorMessage').style.display = 'block';
        document.getElementById('successMessage').style.display = 'none';
    }
});

function clearForm() {
    document.getElementById('contactForm').reset();
}

function resetErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => {
        element.style.display = 'none';
        element.textContent = '';
    });
}

function validateName() {
    const name = document.getElementById('name').value.trim();
    const nameError = document.getElementById('nameError');
    
    if (!name) {
        nameError.textContent = 'Name is required';
        nameError.style.display = 'block';
        return false;
    }
    
    // Check if name contains only letters and spaces
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(name)) {
        nameError.textContent = 'Name should contain only letters';
        nameError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validateEmail() {
    const email = document.getElementById('email').value.trim();
    const emailError = document.getElementById('emailError');
    
    if (!email) {
        emailError.textContent = 'Email is required';
        emailError.style.display = 'block';
        return false;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        emailError.textContent = 'Please enter a valid email address';
        emailError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validatePhone() {
    const phone = document.getElementById('phone').value.trim();
    const phoneError = document.getElementById('phoneError');
    
    if (!phone) {
        phoneError.textContent = 'Phone number is required';
        phoneError.style.display = 'block';
        return false;
    }
    
    // Check if phone contains only numbers
    const phoneRegex = /^\d+$/;
    if (!phoneRegex.test(phone)) {
        phoneError.textContent = 'Phone number should contain only numbers';
        phoneError.style.display = 'block';
        return false;
    }
    
    // Check if phone number is at least 10 digits
    if (phone.length < 10) {
        phoneError.textContent = 'Phone number should be at least 10 digits';
        phoneError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validateAge() {
    const age = document.getElementById('age').value.trim();
    const ageError = document.getElementById('ageError');
    
    if (!age) {
        ageError.textContent = 'Age is required';
        ageError.style.display = 'block';
        return false;
    }
    
    const ageNum = parseInt(age, 10);
    
    if (isNaN(ageNum)) {
        ageError.textContent = 'Age must be a number';
        ageError.style.display = 'block';
        return false;
    }
    
    if (ageNum < 18) {
        ageError.textContent = 'You must be at least 18 years old';
        ageError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validatePassword() {
    const password = document.getElementById('password').value;
    const passwordError = document.getElementById('passwordError');
    
    if (!password) {
        passwordError.textContent = 'Password is required';
        passwordError.style.display = 'block';
        return false;
    }
    
    // Check password complexity
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    
    if (!passwordRegex.test(password)) {
        passwordError.textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character';
        passwordError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validateConfirmPassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    
    if (!confirmPassword) {
        confirmPasswordError.textContent = 'Please confirm your password';
        confirmPasswordError.style.display = 'block';
        return false;
    }
    
    if (password !== confirmPassword) {
        confirmPasswordError.textContent = 'Passwords do not match';
        confirmPasswordError.style.display = 'block';
        return false;
    }
    
    return true;
}

function validateAccountType() {
    const accountType = document.getElementById('accountType').value;
    const accountTypeError = document.getElementById('accountTypeError');
    
    if (accountType === '--Select Account--') {
        accountTypeError.textContent = 'Please select an account type';
        accountTypeError.style.display = 'block';
        return false;
    }
    
    return true;
}