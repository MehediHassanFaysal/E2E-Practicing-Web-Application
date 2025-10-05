<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .toggle-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #007bff;
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
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <button class="toggle-btn" onclick="togglePopup()">☰</button>

    <div class="popup" id="popup">
        <div class="popup-content">
            <h1>Register</h1>
            <form id="registrationForm" onsubmit="return submitForm(event)">
                @csrf
                <div class="error-message" id="error-message"></div>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                
                <input type="text" id="user_type" name="user_type" value="user" hidden>

                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script>
        function togglePopup() {
            var popup = document.getElementById('popup');
            if (popup.classList.contains('active')) {
                popup.classList.remove('active');
            } else {
                popup.classList.add('active');
            }
        }

        async function submitForm(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('registrationForm'));
            const response = await fetch('{{ url('api/register') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const result = await response.json();
                alert(result.message); // Show success message or handle success
                togglePopup(); // Close the popup on successful registration
            } else {
                const errors = await response.json();
                displayErrors(errors.errors);
            }
        }

        function displayErrors(errors) {
            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.innerHTML = '';
            for (const [field, messages] of Object.entries(errors)) {
                messages.forEach(message => {
                    const errorElement = document.createElement('p');
                    errorElement.textContent = message;
                    errorMessageDiv.appendChild(errorElement);
                });
            }
        }
    </script>

</body>
</html>
