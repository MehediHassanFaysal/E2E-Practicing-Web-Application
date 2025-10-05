<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <!-- <link rel="stylesheet" href="profile.css"> -->
    <style>
        /* Reset some default styles */
        body, h1, h2, p {
            margin: 0;
            padding: 0;
        }

        /* Style for the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Profile container styling */
        .profile-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            padding: 20px;
            box-sizing: border-box;
            position: relative; /* For absolute positioning of buttons */
        }

        /* Button container styling */
        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .button-container a {
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 1px;
            /* font-weight: bold; */
            margin-left: 3px;
            display: inline-block;
            background-color: transparent;
            transition: all 0.3s ease; /* Smooth transition for hover effect */
            height: 9px;
            font-size: 10px;
        }

        .button-container a.logout {
            color: #dc3545;
            border-color: #dc3545;
        }

        .button-container a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .button-container a.logout:hover {
            background-color: #dc3545;
            color: #fff;
        }

        /* Header section styling */
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        .name {
            font-size: 2em;
            margin: 10px 0 5px;
        }

        .title {
            color: #666;
            font-style: italic;
        }

        /* Info section styling */
        .profile-info, .contact-info {
            margin-bottom: 20px;
        }

        h2 {
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }

        /* Social links styling */
        .social-links {
            text-align: center;
        }

        .social-links a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            margin: 0 10px;
        }

        .social-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
@if (session('message'))
    <div>{{ session('message') }}</div>
@endif

    <div class="profile-container">
        <div class="button-container">
            <!-- <a href="{{ url()->previous() }}">Back</a> -->
            <a href="{{ route('landingPage', ['session_id' => $sessionId]) }}">Back</a>
            <a href="#" id ="logout-1" class="logout">Logout</a>
        </div>
        <div class="profile-header">
            <img src="" alt="Profile Picture" class="profile-picture">
            <h1 class="name">{{ $loginUser->name }}</h1>
            <p class="title">QA Engineer</p>
        </div>
        <!-- <div class="profile-info">
            <h2>About Me</h2>
             <p> Hashed Password: {{$loginUser->password}} </p>
        </div>  -->
        <div class="contact-info">
            <h2>Information</h2>
            <p>Email: {{ $loginUser->email }}</p>
            <p>User Type: {{$loginUser->user_type}}</p>
        </div>
        <div class="social-links">
            <a href="" target="_blank">LinkedIn</a>
            <a href="" target="_blank">GitHub</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    // Get session ID from a global variable or meta tag
    const sessionId = "{{ session()->getId() }}"; // Embedding session ID in JavaScript
    document.getElementById('logout-1').addEventListener('click', function() {
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
