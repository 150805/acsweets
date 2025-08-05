document.getElementById('contactForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form submission

  // Get input values
  const nameInput = document.getElementById('name').value.trim();
  const emailInput = document.getElementById('email').value.trim();
  const passwordInput = document.getElementById('password').value.trim();
  const confirmPasswordInput = document.getElementById('confirmPassword').value.trim();
  const accountTypeInput = document.getElementById('accountType').value;

  // Get error message elements
  const nameError = document.getElementById('nameError');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');
  const confirmPasswordError = document.getElementById('confirmPasswordError');
  const accountTypeError = document.getElementById('accountTypeError');

  // Reset error messages
  nameError.style.display = 'none';
  emailError.style.display = 'none';
  passwordError.style.display = 'none';
  confirmPasswordError.style.display = 'none';
  accountTypeError.style.display = 'none';

  // Validation flags
  let isValid = true;

  // Validate User Name (only letters and spaces)
  const namePattern = /^[A-Za-z\s]+$/;
  if (!namePattern.test(nameInput)) {
    nameError.textContent = 'User Name should contain only letters and spaces.';
    nameError.style.display = 'block';
    isValid = false;
  }

  // Validate Email
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(emailInput)) {
    emailError.textContent = 'Please enter a valid email address.';
    emailError.style.display = 'block';
    isValid = false;
  }

  // Validate Password (must contain uppercase, lowercase, numbers, and special characters)
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
  if (!passwordPattern.test(passwordInput)) {
    passwordError.textContent = 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.';
    passwordError.style.display = 'block';
    isValid = false;
  }

  // Validate Confirm Password
  if (passwordInput !== confirmPasswordInput) {
    confirmPasswordError.textContent = 'Passwords do not match.';
    confirmPasswordError.style.display = 'block';
    isValid = false;
  }

  // Validate Account Type
  if (accountTypeInput === '--Select Account--') {
    accountTypeError.textContent = 'Please select an account type.';
    accountTypeError.style.display = 'block';
    isValid = false;
  }

  // If all inputs are valid
  if (isValid) {
    // Notify the user with a dialog box
    alert(`You, ${nameInput}, have successfully filled out the form!`);

    // Clear the form
    document.getElementById('contactForm').reset();
  } else {
    // Display error message
    document.getElementById('errorMessage').style.display = 'block';
    document.getElementById('successMessage').style.display = 'none';
  }
});