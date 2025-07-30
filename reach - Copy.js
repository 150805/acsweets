document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission
document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById('loginForm'); // Select the login form
  if (loginForm) {
    loginForm.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent form submission

      // Get input values
      const username = document.getElementById('username').value;
      const password = document.getElementById('password').value;

      // Simple validation
      if (username === 'user' && password === 'password') {
        alert('Login successful!');
        // Redirect or perform other actions here
      } else {
        document.getElementById('error-message').textContent =
          'Invalid username or password';
      }
    });
  }

  // Sign-Up Form Validation
  const signupForm = document.querySelector('form'); // Select the sign-up form
  if (signupForm) {
    const nameInput = document.getElementById('name'); // Username input field
    const emailInput = document.getElementById('email'); // Email input field
    const passwordInput = document.getElementById('password'); // Password input field

    signupForm.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the form from submitting

      // Clear previous error messages
      clearErrors();

      // Validate username
      if (!nameInput.value.trim()) {
        showError(nameInput, 'Username is required.');
        return;
      } else if (nameInput.value.trim().length < 3) {
        showError(nameInput, 'Username must be at least 3 characters long.');
        return;
      }

      // Validate email
      if (!emailInput.value.trim()) {
        showError(emailInput, 'Email is required.');
        return;
      } else if (!validateEmail(emailInput.value.trim())) {
        showError(emailInput, 'Please enter a valid email address.');
        return;
      }

      // Validate password
      if (!passwordInput.value.trim()) {
        showError(passwordInput, 'Password is required.');
        return;
      } else if (passwordInput.value.trim().length < 8) {
        showError(passwordInput, 'Password must be at least 8 characters long.');
        return;
      } else if (!validatePassword(passwordInput.value.trim())) {
        showError(
          passwordInput,
          'Password must contain at least one number and one special character.'
        );
        return;
      }

      // If all validations pass, submit the form
      alert('Sign up successful! Welcome to Artful Expressions.');
      signupForm.reset(); // Clear the form
    });

    // Function to validate email format
    function validateEmail(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }

    // Function to validate password
    function validatePassword(password) {
      const regex = /^(?=.*\d)(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
      return regex.test(password);
    }

    // Function to display error messages
    function showError(input, message) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.style.color = 'red';
      errorDiv.style.marginTop = '5px';
      errorDiv.textContent = message;
      input.insertAdjacentElement('afterend', errorDiv); // Insert error message after the input field
    }

    // Function to clear previous error messages
    function clearErrors() {
      const errors = document.querySelectorAll('.error-message');
      errors.forEach((error) => error.remove());
    }
  }
});