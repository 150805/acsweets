document.getElementById('contactForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent form submission

  // Get form inputs
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();
  const confirmPassword = document.getElementById('confirmPassword').value.trim();
  const message = document.getElementById('message').value.trim();

  // Validation flags
  let isNameValid = false;
  let isEmailValid = false;
  let isPasswordValid = false;
  let isConfirmPasswordValid = false;

  // Validate Name (characters only)
  const nameRegex = /^[A-Za-z\s]+$/;
  if (nameRegex.test(name)) {
    isNameValid = true;
  } else {
    alert('Name must contain only letters and spaces.');
  }

  // Validate Email
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (emailRegex.test(email)) {
    isEmailValid = true;
  } else {
    alert('Please enter a valid email address.');
  }

  // Validate Password (uppercase, lowercase, number, and special character)
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
  if (passwordRegex.test(password)) {
    isPasswordValid = true;
  } else {
    alert('Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.');
  }

  // Validate Confirm Password
  if (password === confirmPassword) {
    isConfirmPasswordValid = true;
  } else {
    alert('Passwords do not match.');
  }

  // Display success or error message
  const errorMessage = document.getElementById('errorMessage');
  const successMessage = document.getElementById('successMessage');

  if (isNameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
    // Clear the form
    document.getElementById('contactForm').reset();

    // Display success message in a dialog box
    alert(`You, ${name}, have successfully submitted the form!`);

    // Display success message on the page
    errorMessage.style.display = 'none';
    successMessage.style.display = 'block';
    successMessage.textContent = 'Form submitted successfully!';
  } else {
    // Display error message
    successMessage.style.display = 'none';
    errorMessage.style.display = 'block';
    errorMessage.textContent = 'Please fix the errors in the form.';
  }
});