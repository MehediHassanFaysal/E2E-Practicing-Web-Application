<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            position: relative; /* Ensures the logout button is positioned relative to the body */
        }
        .logout-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: absolute; /* Position the button absolutely */
            top: 20px; /* Distance from the top of the page */
            right: 20px; /* Distance from the right side of the page */
        }
        .logout-button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 20px;
        }
        .content {
            margin-top: 60px; /* Space for the logout button */
        }
    </style>
</head>
<body>
    <!-- Logout Button -->
    <button id="logout-button" class="logout-button">Logout</button>

    <h1>Welcome to the Landing Page!</h1>
    
    <!-- Logout Form -->
    <form id="logout-form" style="display: none;">
        @csrf
        <button type="submit" class="logout-button">Logout</button>
    </form>

    <div id="error-message" class="error-message"></div>

    <!-- Include Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Pass session ID to JavaScript -->
    <script>
        // Get session ID from a global variable or meta tag
        const sessionId = "{{ session()->getId() }}"; // Embedding session ID in JavaScript
        document.getElementById('logout-button').addEventListener('click', function() {
            // Send a POST request to logout
            axios.post('/api/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            })
            .then(response => {
                // Successfully logged out
                // Remove the token from local storage
                localStorage.removeItem('token');

                // Redirect to the homepage or another page
                window.location.href = '/';
            })
            .catch(error => {
                // Handle errors (e.g., log error message)
                console.error('Logout failed:', error.response ? error.response.data : error.message);
                document.getElementById('error-message').textContent = 'Logout failed. Please try again.';
            });
        });
    </script>
</body>
</html>
