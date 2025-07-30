document.getElementById('contactForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent form submission

  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const phone = document.getElementById('phone').value.trim();
  const message = document.getElementById('message').value.trim();

 
  const nameError = document.getElementById('nameError') || createErrorElement('name');
  const emailError = document.getElementById('emailError') || createErrorElement('email');
  const phoneError = document.getElementById('phoneError') || createErrorElement('phone');
  const messageError = document.getElementById('messageError') || createErrorElement('message');

 
  nameError.textContent = '';
  emailError.textContent = '';
  phoneError.textContent = '';
  messageError.textContent = '';

  
  let isNameValid = false;
  let isEmailValid = false;
  let isPhoneValid = false;
  let isMessageValid = false;


  const nameRegex = /^[A-Za-z\s]+$/;
  if (nameRegex.test(name)) {
    isNameValid = true;
  } else {
    nameError.textContent = 'Name must contain only letters and spaces.';
  }

 
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (emailRegex.test(email)) {
    isEmailValid = true;
  } else {
    emailError.textContent = 'Please enter a valid email address.';
  }

  // Validate Phone Number (must start with +254 and be 13 digits long)
  const phoneRegex = /^\+254\d{9}$/;
  if (phoneRegex.test(phone)) {
    isPhoneValid = true;
  } else {
    phoneError.textContent = 'Phone number must start with +254 and be 13 digits long (e.g., +254712345678).';
  }


  if (message.length > 0) {
    isMessageValid = true;
  } else {
    messageError.textContent = 'Message cannot be empty.';
  }


  const errorMessage = document.getElementById('errorMessage');
  const successMessage = document.getElementById('successMessage');

  if (isNameValid && isEmailValid && isPhoneValid && isMessageValid) {
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

// Helper function to create error message elements
function createErrorElement(inputId) {
  const errorElement = document.createElement('span');
  errorElement.id = `${inputId}Error`;
  errorElement.style.color = 'red';
  errorElement.style.display = 'block';
  errorElement.style.marginTop = '5px';
  document.getElementById(inputId).insertAdjacentElement('afterend', errorElement);
  return errorElement;
}