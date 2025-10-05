<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }
        .login-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="submit"] {
            /* background-color: #007bff; */
            background-color: #2471a3;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #27ae60;
        }
        .form-group select {
            width: 100%; /* Ensure the select field takes full width of the .form-group container */
            /* max-width: 300px; Optional: Set a maximum width for the select field */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            /* margin: 0 auto; Center the select field horizontally */
            display: block; /* Make sure it's a block element to use margin auto */
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .forgot-password {
            margin-top: 10px;
            font-size: 14px;
        }
        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Registration Popup Styles */
        .toggle-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            z-index: 1001;
        }
        .popup {
            position: fixed;
            top: 0;
            right: -100%; /* Initially hidden to the right side */
            width: 300px;
            height: 100%;
            background: #fff;
            border-left: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1000;
        }
        .popup.active {
            right: 0; /* Slide in from the right */
        }
        .popup-content {
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }
        .popup-content h1 {
            margin-top: 0;
        }
        .popup-content form {
            display: flex;
            flex-direction: column;
        }
        .popup-content label {
            margin-bottom: 5px;
        }
        .popup-content input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .popup-content button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .popup-content button:hover {
            background-color: #0056b3;
        }

        .alert-fail {
            position: fixed;
            top: 20px; /* Distance from the top of the page */
            right: 20px; /* Distance from the right edge of the page */
            background-color: #f44336; /* Red background color for alert */
            color: white; /* White text color */
            padding: 15px; /* Padding inside the alert */
            border-radius: 5px; /* Rounded corners */
            z-index: 1000; /* Ensure it appears above other content */
            display: none; /* Hidden by default */
        }

        .alert-fail.show {
            display: block; /* Show alert */
        }
        .alert-success {
            position: fixed;
            top: 20px; /* Distance from the top of the page */
            right: 20px; /* Distance from the right edge of the page */
            background-color: #58d68d; /* Sky-blue background color for alert */
            color: white; /* White text color */
            padding: 15px; /* Padding inside the alert */
            border-radius: 5px; /* Rounded corners */
            z-index: 1000; /* Ensure it appears above other content */
            display: none; /* Hidden by default */
        }

        .alert-success.show {
            display: block; /* Show alert */
        }


    </style>
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>

@if (session('message'))
    <div>{{ session('message') }}</div>
@endif

        <form id="login-form">
            <div class="form-group">
                <!-- <label for="email">Email</label> -->
                <input type="email" id="email" name="email" placeholder="Enter Email Address">
            </div>
            <div class="form-group">
                <!-- <label for="password">Password</label> -->
                <input type="password" id="password" name="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <!-- <label for="user-type">User Type</label> -->
                <select id="user-type" name="user-type">
                    <option value="" disabled selected>Select User Type</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" id="loginButton" value="Login">
            </div>
            <div class="error-message" id="error-message">
                <!-- Error messages will be dynamically inserted here -->
            </div>
        </form>
        <div>
            <a href="/forgot" style="color: red; font-size: 12px;">Forgot your password?</a>
        </div>
        <div class="forgot-password">
            <button class="toggle-btn" onclick="togglePopup()">Register</button>
        </div>
    </div>


    <!-- Registration Popup -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <h1>Register</h1>
            <form id="registration-form">
                @csrf
                <div class="error-message" id="registration-error-message"></div>

                <!-- <label for="name">Name:</label> -->
                <input type="text" id="name" name="name" placeholder="Enter Name">

                <!-- <label for="email">Email:</label> -->
                <input type="email" id="reg-email" name="email" placeholder="Enter Email Address">

                <!-- <label for="password">Password:</label> -->
                <input type="password" id="reg-password" name="password" placeholder="Enter Password">

                <!-- <label for="password_confirmation">Confirm Password:</label> -->
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password">
                
                <!-- <label for="password_confirmation">User Type:</label> -->
                <input type="text" id="utype" name="user-type" hidden>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script>

    // Function to show the alert message
    function showSuccessAlert(message, type = 'error') {
        // Create the alert element
        const alert = document.createElement('div');
        alert.className = `alert-success ${type}`;
        alert.innerText = message;
        
        // Append the alert to the body
        document.body.appendChild(alert);
        
        // Show the alert
        alert.classList.add('show');
        
        // Automatically remove the alert after 3 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            // Remove the alert element from the DOM
            alert.remove();
        }, 5000);
    }

    function showFailureAlert(message, type = 'error') {
        // Create the alert element
        const alert = document.createElement('div');
        alert.className = `alert-fail ${type}`;
        alert.innerText = message;
        
        // Append the alert to the body
        document.body.appendChild(alert);
        
        // Show the alert
        alert.classList.add('show');
        
        // Automatically remove the alert after 3 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            // Remove the alert element from the DOM
            alert.remove();
        }, 3000);
    }


        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const user_type = document.getElementById('user-type').value; // Get the selected user type
            const errorMessage = document.getElementById('error-message');

            axios.post('/api/login', { email, password, user_type }) // Include user_type in the request
                .then(response => {
                    showSuccessAlert('Login successful!', 'success');

                    const { token, user_info } = response.data;
                    localStorage.setItem('token', token); // Store the token
                    localStorage.setItem('user_type', user_info.user_type); // Store user type
        
                    // Redirect based on the user type
                    if (user_type === 'admin') {
                        // Construct the full redirect URL
                        const baseUrl = '/view-admin';
                        const sessionId = response.data.session_id; // Ensure `session_id` is returned from the API response
                        const redirectUrl = `${baseUrl}?session_id=${encodeURIComponent(sessionId)}`;

                        // Redirect to the constructed URL
                        window.location.href = redirectUrl;
                    }
                    else {
                        // Default redirect if userType is not set
                        // window.location.href = '/landing-page';
                        const baseUrl = '/landing-page';
                        const sessionId = response.data.session_id; // Ensure `session_id` is returned from the API response
                        const redirectUrl = `${baseUrl}?session_id=${encodeURIComponent(sessionId)}`;

                        // Redirect to the constructed URL
                        window.location.href = redirectUrl;
                    }

                })
                .catch(error => {
                    console.error('Login failed:', error.response ? error.response.data : error.message);
                     // Display an error alert
                     showFailureAlert(error.response && error.response.data.errors
                        ? Object.values(error.response.data.errors).flat().join(' ')
                    : 'Login failed. Please try again.');
                
                });

                axios.get('api/landingpage', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
            .then(response => {
                // Handle the response
        })
        .catch(error => {
            console.error('Request failed:', error.response ? error.response.data : error.message);
        });
        });

        document.getElementById('registration-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            // Set user type value dynamically
            document.getElementById('utype').value = 'user';
            const name = document.getElementById('name').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const user_type = document.getElementById('utype').value;
            const registrationErrorMessage = document.getElementById('registration-error-message');

            axios.post('/api/register', { name, email, password, password_confirmation: passwordConfirmation, user_type })
                .then(response => {
                    // alert('Registration successful!');
                    showSuccessAlert('Registration successful!', 'success');

                    // Clear page elements
                    document.getElementById('name').value = '';
                    document.getElementById('reg-email').value = '';
                    document.getElementById('reg-password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    document.getElementById('utype').value = '';
                    togglePopup(); // Close the popup on successful registration
                })
                .catch(error => {
                    console.error('Registration failed:', error.response ? error.response.data : error.message);
                    // Display an error alert
                    showFailureAlert(error.response && error.response.data.errors
                        ? Object.values(error.response.data.errors).flat().join(' ')
                    : 'Registration failed. Please try again.');


                });
        });

        function togglePopup() {
            var popup = document.getElementById('popup');
            if (popup.classList.contains('active')) {
                popup.classList.remove('active');
            } else {
                popup.classList.add('active');
            }
        }
    </script>
</body>
</html>
