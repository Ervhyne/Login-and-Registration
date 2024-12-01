document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const message = document.getElementById('message');
    let errorType = '';


    // Basic validation
    if (username === '' || email === '' || password === '') {
        errorType = 'empty';
    } else if (username.length < 6) {
        errorType = 'shortUsername';
    } else if (!/\S+@\S+\.\S+/.test(email)) {
        errorType = 'invalidEmail';
    } else if (password.length < 6) {
        errorType = 'shortPassword';
    }

    // Handle validation errors or success
    switch (errorType) {
        case 'empty':
            message.textContent = 'All fields are required.';
            break;
        case 'shortUsername':
            message.textContent = 'Username must be at least 6 characters long.';
            break;
        case 'invalidEmail':
            message.textContent = 'Please enter a valid email address.';
            break;
        case 'shortPassword':
            message.textContent = 'Password must be at least 6 characters long.';
            break;
        default:
            // Log the registration details to the console, omitting the password
            console.log('Registration Details:', {
                username: username,
                email: email,
                password: password
                // Don't log the password for security reasons
            });

            message.textContent = 'Registration successful!';

            // Clear form fields
            document.getElementById('registrationForm').reset();
            break;
    }
});
