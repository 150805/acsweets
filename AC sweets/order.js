document.getElementById('orderForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent form submission

  // Get the cake type input
  const cakeType = document.getElementById('title').value.trim();

  // List of valid cake types
  const validCakeTypes = [
    'Chocolate cake',
    'Fruit cake',
    'Vegeterian/Special cake',
    'Forest/Velvet cake'
  ];

  // Check if the cake type is valid
  const isCakeTypeValid = validCakeTypes.includes(cakeType);

  // Display error or success message
  const errorMessage = document.getElementById('errorMessage');
  const successMessage = document.getElementById('successMessage');

  if (isCakeTypeValid) {
    // Clear the form
    document.getElementById('orderForm').reset();

    // Display success message
    errorMessage.style.display = 'none';
    successMessage.style.display = 'block';
    successMessage.textContent = 'Order submitted successfully!';

    // Optionally, submit the form programmatically
    // this.submit();
  } else {
    // Display error message
    successMessage.style.display = 'none';
    errorMessage.style.display = 'block';
    errorMessage.textContent = 'Please select a valid cake type from the sweets option.';
  }
});