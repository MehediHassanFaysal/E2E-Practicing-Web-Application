<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Landing Page</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font: 1em sans-serif;
            font-size: 12px;
            height: 20px; /* Adjust the height of cells */
            width: 15px;
        }
        th {
            background-color: #d2b4de;
        }
        td {
            background-color: #f8f9f9;
        }



        .header {
            width: 100%;
            display: flex;
            justify-content: center;
            /* background-color: #f0f0f0; */
        }

        .steps {
            list-style: none;
            padding: 10px 0;
            margin: 0;
            display: flex;
            align-items: center;
            position: relative;
            width: 100%;
            max-width: 1200px;
            justify-content: center;
        }

        .steps li {
            position: relative;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 0 10px;
            font-size: 12px;
            cursor: pointer;
        }

        .steps li:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -10px;
            width: 20px;
            height: 2px;
            background-color: red;
            transform: translateY(-50%);
        }

        .steps li.active {
            font-weight: bold;
            color: #229954;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin-top: 10px;
        }

        .section {
            display: none;
            padding: 20px;
            text-align: center;
            background-color: #fcfcfc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 70%;
            position: absolute;
        }

        .section.active {
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        select{
            display: block;
            margin: 10px auto;
            padding: 10px;
            font-size: 11px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: calc(100% - 22px); /*Adjust width considering padding and border */
        }
        .navigation {
            position: absolute;
            top: 22px;
            right: 28px;
        }
        .button-container {
            display: flex;
            gap: 10px; /* Adjust spacing between buttons if needed */
            justify-content: center; /* Centers buttons horizontally, remove or adjust if needed */
            margin-top: 20px; /* Adjust spacing above buttons if needed */
        }

        button {
            padding: 10px 20px;
            font-size: 10px;
            border: none;
            border-radius: 2px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            margin: 0 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        #submitButton {
            background-color: #28a745;
        }

        #submitButton:hover {
            background-color: #218838;
        }

        .review-section {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            margin-bottom: 20px; /* Ensure spacing before the submit button */
        }

        .review-section h2 {
            margin-bottom: 20px;
        }

        .review-section p {
            margin: 10px 0;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        


        /* The Modal (background) */
        /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Center the modal vertically and horizontally */
    padding: 20px;
    border: 1px solid #888;
    width: 50%; /* Modal width */
    max-width: 800px; /* Optional: Set a maximum width to avoid overly large modals */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add shadow for better visual appearance */
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body>
@if (session('message'))
    <div>{{ session('message') }}</div>
@endif
<div class="container mt-3">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
         @endif


  <!-- <h2>Toggleable Tabs</h2> -->
  <br>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <!-- <a class="nav-link active" data-bs-toggle="tab" href="home">Home</a> -->
      <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="margin-left: 110px;">Admin User</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="menu1-tab" data-bs-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="false">General User</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="menu2-tab" data-bs-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">User Registration</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="menu3-tab" data-bs-toggle="tab" href="#menu3" role="tab" aria-controls="menu3" aria-selected="false">Account Creation</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="menu5-tab" data-bs-toggle="tab" href="#menu5" role="tab" aria-controls="menu5" aria-selected="false" onclick="location.reload();">Refresh Page</a>
      </li>
	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $loginUser->name }} ( {{$loginUser->member_code}} )
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <li>
                <a class="dropdown-item" onclick="location.reload();">Refresh Page</a>
            </li> -->
          <li>
            <a class="dropdown-item" href="{{ route('view.user.profile', ['view' => true,'session_id' => $sessionId]) }}" id="profile" style="color:green" >Profile</a>
         </li>
          <li>
            <a class="dropdown-item" href="#" id="logout" style="color:red;">Logout</a>
         </li>
        </ul>
      </li>
  </ul>

  <script>
    // Get session ID from a global variable or meta tag
    const sessionId = "{{ session()->getId() }}"; // Embedding session ID in JavaScript
    
    document.getElementById('logout').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior

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
  <!-- Tab panes -->
  <div class="tab-content mt-2" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <!-- Admin Form -->
    <form id="adminForm" method="POST" action="">
        @csrf
        @method('PUT')
        <input type="hidden" id="admin_id" name="id" style="pointer-events: none;"> <!-- Hidden input for storing the admin ID -->
        <input type="text" id="name" name="name" placeholder="Name" required>
        <input type="email" id="email" name="email" placeholder="Email" required>
        <input type="text" id="user_type" name="user_type" placeholder="User Type" required style="display:none; pointer-events: none;">
        <div style="display: flex; justify-content: center; margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="font-size: 10px;">Update</button>
            <button type="button" id="clear-admin-button" class="btn btn-warning" style="font-size: 10px;">Clear</button>
        </div>
    </form>

    <!-- Admin Table -->
    <table>
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Email Address</b></th>
                <th><b>User Type</b></th>
                <th><b>Actions</b></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
                <tr data-id="{{ $admin->id }}" data-name="{{ $admin->name }}" data-email="{{ $admin->email }}" data-user_type="{{ $admin->user_type }}">
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->user_type }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm open-modal" style="height: 23px; width: 70px; font-size: 9.5px">Edit</button>
                        <!-- Delete Button (with confirmation) -->
                        <form action="{{ route('users.destroy', ['id' => $admin->id, 'session_id' => $sessionId]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" style="height: 23px; width: 70px; font-size: 9.5px">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.open-modal');

        // Add click event listener to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the parent row (tr element) of the clicked button
                const row = this.closest('tr');

                // Get data attributes from the row
                const adminId = row.getAttribute('data-id');
                const name = row.getAttribute('data-name');
                const email = row.getAttribute('data-email');
                const userType = row.getAttribute('data-user_type');

                // Populate the form fields
                document.getElementById('admin_id').value = adminId;
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('user_type').value = userType;

                // Update the form action URL with the admin ID
                document.getElementById('adminForm').action = `/users/${adminId}?session_id=${sessionId}`;
                showSuccessAlert('Successfully Admin Data Fetched!', 'success');
            });
        });
        // showSuccessAlert('Successful!', 'success');
    });
</script>
<script>
        document.getElementById('clear-admin-button').addEventListener('click', function() {
            // Select the form
            var form = document.getElementById('adminForm');
            // Reset the form fields
            form.reset();
        });
</script>  
<div class="tab-pane fade" id="menu1" role="tabpanel" aria-labelledby="menu1-tab">
    <form id="userForm" method="POST" action="">
        @csrf
        @method('PUT')
        <input type="hidden" id="user_id" name="id" style="pointer-events: none;"> <!-- Hidden input for storing the admin ID -->
        <input type="text" id="usr_name" name="name" placeholder="Name" required>
        <input type="email" id="usr_email" name="email" placeholder="Email" required>
        <input type="text" id="usr_user_type" name="user_type" placeholder="User Type" required style="display:none; pointer-events: none;">
        <div style="display: flex; justify-content: center; margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="font-size: 10px;">Update</button>
            <button type="button" id="clear-user-button" class="btn btn-warning" style="font-size: 10px;">Clear</button>
        </div> 
    </form>
    <!-- <h1>Users Table</h1> -->
    <table>
        <thead>
            <tr>
                <th><b> Name </b></th>
                <th><b>Email Address</b></th>
                <th><b>User Type</b></th>
                <th><b>Actions</b></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr data-usr-id="{{ $user->id }}" data-usr-name="{{ $user->name }}" data-usr-email="{{ $user->email }}" data-usr-user_type="{{ $user->user_type }}">

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->user_type }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary btn-sm open-modal" style="height: 23px; width: 70px; font-size: 9.5px">Edit</button>
                        <!-- Delete Button (with confirmation) -->
                        <form action="{{ route('users.destroy', ['id' => $user->id, 'session_id' => $sessionId]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')" Style="height: 23px; width: 70px; font-size: 9.5px">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No users found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all edit buttons
        const editButtons = document.querySelectorAll('.open-modal');

        // Add click event listener to each edit button
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the parent row (tr element) of the clicked button
                const row = this.closest('tr');

                // Get data attributes from the row
                const userId = row.getAttribute('data-usr-id');
                const name = row.getAttribute('data-usr-name');
                const email = row.getAttribute('data-usr-email');
                const userType = row.getAttribute('data-usr-user_type');

                // Populate the form fields
                document.getElementById('user_id').value = userId;
                document.getElementById('usr_name').value = name;
                document.getElementById('usr_email').value = email;
                document.getElementById('usr_user_type').value = userType;

                // Update the form action URL with the admin ID
                document.getElementById('userForm').action = `/users/${userId}?session_id=${sessionId}`;
                showSuccessAlert('Successfully User Data Fetched!', 'success');
            });
        });
        // showSuccessAlert('Successful!', 'success');
    });
</script>
<script>
        document.getElementById('clear-user-button').addEventListener('click', function() {
            // Select the form
            var form = document.getElementById('userForm');
            // Reset the form fields
            form.reset();
        });
</script>  




    <div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="menu2-tab">
      <h3 style="text-align: center">User Registration</h3>
       
        <form id="registration-form">
            @csrf
            <div class="error-message" id="registration-error-message"></div>

            <div class="form-group">
                <!-- <label for="name">Name:</label> -->
                <input type="text" id="reg-name" name="name" placeholder="Enter Full Name">
            </div>

            <div class="form-group">
                <!-- <label for="email">Email:</label> -->
                <input type="email" id="reg-email" name="email" placeholder="Enter Email Address">
            </div>

            <div class="form-group">
                <!-- <label for="password">Password:</label> -->
                <input type="password" id="reg-password" name="password" placeholder="Enter Password">
                <p style="font-size: 9px; padding-left: 11px; color: red;">At least one special character, one uppercase letter, one lowercase letter, and one number</p>
            </div>

            <div class="form-group">
                <!-- <label for="password_confirmation">Confirm Password:</label> -->
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password">
            </div>

            <div class="form-group">
                <!-- <label for="user-type">User Type:</label> -->
                <select id="utype" name="user-type" >
                    <option value="">Select User Type</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 10px;">
             <button type="submit" id="register-button"class="btn btn-primary" style="font-size: 10px;">Register</button>
             <button type="button" id="clear-button" class="btn btn-warning" style="font-size: 10px;">Clear</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('clear-button').addEventListener('click', function() {
            // Select the form
            var form = document.getElementById('registration-form');
            
            // Reset the form fields
            form.reset();
            
            // Clear any error messages
            document.getElementById('registration-error-message').textContent = '';
        });
    </script>   


    <div class="tab-pane fade" id="menu3" role="tabpanel" aria-labelledby="menu3-tab">
    <div class="header">
        <ul class="steps">
            <li id="step1" class="active">Personal Information</li>
            <li id="step2">Nominee Information</li>
            <li id="step3">Introducer Information</li>
            <li id="step4">Account Information</li>
            <li id="step5">Review & Submit</li>
        </ul>
    </div>
    <form id="multiStepForm" >
        @csrf
        <div id="error-message" class="error-message"></div>
        <div class="main-container">
            <!-- Section 1 -->
            <div class="section active" id="section1">
                <h4>Personal Information</h4>
                <input type="text" id="input1-1" name="member_code" placeholder="Member Code" required>
                <input type="text" id="input1-2" name="mobile_number" placeholder="Mobile Number" required>
                <input type="text" id="input1-3" name="nation_id_card" placeholder="National ID Card Number" required>
                <input type="text" id="input1-4" name="dob" placeholder="Date of Birth (dd/mm/yyyy)" required>
                <select id="input1-5" name="occupation" required>
                    <option value="">Select User Occupation</option>
                    <option value="self_employment">Self Employment</option>
                    <option value="engineer">Engineer</option>
                    <option value="doctor">Doctor</option>
                    <option value="teacher">Teacher</option>
                    <option value="farmer">Farmer</option>
                    <option value="govt_officer">Govt. Officer</option>
                </select>
                <input type="number" id="input1-6" name="anual_income" placeholder="Annual Income" required>
                <input type="text" id="input1-7" name="present_address" placeholder="Present Address" required>
                <input type="text" id="input1-8" name="permanent_address" placeholder="Permanent Address"required>

                <div class="navigation">
                    <button type="button" id="prevButton1" class="btn btn-outline-warning">Previous</button>
                    <button type="button" id="nextButton1" class="btn btn-outline-secondary" style="font-size: 10px;">Next</button>
                    <button type="button" id="clearButton1" class="btn btn-outline-warning" style="font-size: 10px;">Clear</button>
                </div>
            </div>
            <script>
                document.getElementById('clearButton1').addEventListener('click', function() {
                    // Select the form
                    var form = document.getElementById('multiStepForm');
                    // Reset the form fields
                    form.reset();
                });
            </script> 
            
            <!-- Section 2 -->
            <div class="section" id="section2">
                <h4>Nominee Information</h4>
                <input type="text" id="input2-1" name="nominee_name" placeholder="Nominee Name" required>
                <input type="text" id="input2-2" name="age" placeholder="Nominee Age" required>
                <input type="text" id="input2-3" name="nominee_mobile_number" placeholder="Nominee Mobile Number" required>
                <input type="text" id="input2-4" name="nid_number" placeholder="Nominee NID Card Number" required>
                <input type="text" id="input2-5" name="birth_id" placeholder="Nominee Birth Certificate Number" >
                <input type="text" id="input2-6" name="percentage" placeholder="Percentage" value="100" required>
                <select id="input2-7" name="relation_with_member" required>
                    <option value="">Select Relation With Nominee</option>
                    <option value="brother">Brother</option>
                    <option value="father">Father</option>
                    <option value="mother">Mother</option>
                    <option value="sister">Sister</option>
                    <option value="daughter">Daughter</option>
                    <option value="son">Son</option>
                    <option value="wife">Wife</option>
                </select>

                <div class="navigation">
                    <button type="button" id="prevButton2" class="btn btn-outline-warning" style="font-size: 10px;">Previous</button>
                    <button type="button" id="nextButton2" class="btn btn-outline-secondary" style="font-size: 10px;">Next</button>
                </div>
            </div>

            <!-- Section 3 -->
            <div class="section" id="section3">
                <h4>Introducer Information</h4>
                <input type="text" id="input3-1" name="introducer_account" placeholder="Introducer Account" required>
                <input type="text" id="input3-2" name="introducer_name" placeholder="Introducer Name" required>
                <input type="text" id="input3-3" name="introducer_nid" placeholder="Introducer NID Number" required>
                <input type="text" id="input3-4" name="introducer_mobile_number" placeholder="Introducer Mobile Number" required>
                <input type="text" id="input3-5" name="remaks" placeholder="Remarks">

                <div class="navigation">
                    <button type="button" id="prevButton3" class="btn btn-outline-warning" style="font-size: 10px;">Previous</button>
                    <button type="button" id="nextButton3" class="btn btn-outline-secondary" style="font-size: 10px;">Next</button>
                </div>
            </div>

            <!-- Section 4 -->
            <div class="section" id="section4">
                <h4>Account Information</h4>
                <input type="text" id="input4-1" name="account_type" placeholder="Account Type" value="Savings" required>
                <input type="number" id="input4-2" name="amount" placeholder="Amount" value="500" required>
  
                <div class="navigation">
                    <button type="button" id="prevButton4" class="btn btn-outline-warning" style="font-size: 10px;">Previous</button>
                    <button type="button" id="nextButton4" class="btn btn-outline-secondary" style="font-size: 10px;">Next</button>
                </div>
            </div>


            
            <!-- Section 5 -->
            <div class="section" id="section5">
                <h4>Review</h4>
                <div id="reviewSection"></div> <!-- Review results will be displayed here -->
                <div class="navigation">
                    <button type="button" id="prevButton5" class="btn btn-outline-warning" style="font-size: 10px;">Previous</button>
                    <button type="submit" id="submitButton" class="btn btn-outline-success" style="font-size: 10px;">Submit</button>
                </div>
            </div>
        </div>
    </form>
    </div>
  </div>
</div>


<!-- Include Axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
    }, 4000);
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
    }, 4000);
}

document.getElementById('registration-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const name = document.getElementById('reg-name').value;
            const email = document.getElementById('reg-email').value;
            const password = document.getElementById('reg-password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const user_type = document.getElementById('utype').value;
            const registrationErrorMessage = document.getElementById('registration-error-message');

            axios.post('/api/register', { name, email, password, password_confirmation: passwordConfirmation, user_type })
                .then(response => {
                    // alert('Registration successful!');
                    // Show success alert
                    showSuccessAlert('Registration successful!', 'success');

                    // Clear page elements (example)
                    document.getElementById('reg-name').value = '';
                    document.getElementById('reg-email').value = '';
                    document.getElementById('reg-password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    document.getElementById('utype').value = '';
                })
                .catch(error => {
                    console.error('Registration failed:', error.response ? error.response.data : error.message);
                    
                    // Display an error alert
                    showFailureAlert(error.response && error.response.data.errors
                        ? Object.values(error.response.data.errors).flat().join(' ')
                    : 'Registration failed. Please try again.');
                });

        });
 </script>



<script>
    
    let currentSection = 1;
    const totalSections = 5;
    let isSubmitting = false; // Track submission status

    function updateButtons() {
        for (let i = 1; i <= totalSections; i++) {
            const nextButton = document.getElementById(`nextButton${i}`);
            const prevButton = document.getElementById(`prevButton${i}`);
            if (nextButton && prevButton) {
                nextButton.style.display = (currentSection === i && i < totalSections) ? 'inline-block' : 'none';
                prevButton.style.display = (currentSection === i && i > 1) ? 'inline-block' : 'none';
            }
        }
        document.getElementById('submitButton').style.display = (currentSection === totalSections) ? 'inline-block' : 'none';
    }

    function updateReviewSection() {
        if (currentSection !== totalSections) return;

        const reviewSection = document.getElementById('reviewSection');
        const inputs = {
            member_code: document.getElementById('input1-1').value,
            mobile_number: document.getElementById('input1-2').value,
            nation_id_card: document.getElementById('input1-3').value,
            dob: document.getElementById('input1-4').value,
            occupation: document.getElementById('input1-5').value,
            anual_income: document.getElementById('input1-6').value,
            present_address: document.getElementById('input1-7').value,
            permanent_address: document.getElementById('input1-8').value,
            nominee_name: document.getElementById('input2-1').value,
            age: document.getElementById('input2-2').value,
            nominee_mobile_number: document.getElementById('input2-3').value,
            nid_number: document.getElementById('input2-4').value,
            birth_id: document.getElementById('input2-5').value,
            percentage: document.getElementById('input2-6').value,
            relation_with_member: document.getElementById('input2-7').value,
            introducer_account: document.getElementById('input3-1').value,
            introducer_name: document.getElementById('input3-2').value,
            introducer_nid: document.getElementById('input3-3').value,
            introducer_mobile_number: document.getElementById('input3-4').value,
            remarks: document.getElementById('input3-5').value,
            account_type: document.getElementById('input4-1').value,
            amount: document.getElementById('input4-2').value,
        };

        reviewSection.innerHTML = `
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #fff; padding: 8px; text-align: left;" colspan="2">Account Information</th>
                    </tr>
                </thead>
                <tbody>
                    ${Object.entries(inputs).map(([key, value]) => `
                        <tr>
                          <td style="border: 1px solid #fff; padding: 8px;">${key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}:</td>
                          <td style="border: 1px solid #fff; padding: 8px;">${value}</td> 
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function validateSection() {
        const inputs = document.querySelectorAll(`#section${currentSection} input[required], #section${currentSection} select[required]`);
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                valid = false;
                input.reportValidity();
            }
        });
        return valid;
    }

    function showNextSection() {
        if (!validateSection()) return;

        document.getElementById(`section${currentSection}`).classList.remove('active');
        document.getElementById(`step${currentSection}`).classList.remove('active');

        currentSection++;
        if (currentSection > totalSections) {
            currentSection = 1; // Loop back to the first section
        }

        document.getElementById(`section${currentSection}`).classList.add('active');
        document.getElementById(`step${currentSection}`).classList.add('active');

        updateButtons();
        updateReviewSection();
    }

    function showPreviousSection() {
        document.getElementById(`section${currentSection}`).classList.remove('active');
        document.getElementById(`step${currentSection}`).classList.remove('active');

        currentSection--;
        if (currentSection < 1) {
            currentSection = totalSections; // Loop back to the last section
        }

        document.getElementById(`section${currentSection}`).classList.add('active');
        document.getElementById(`step${currentSection}`).classList.add('active');

        updateButtons();
        updateReviewSection();
    }

    function submitForm() {
        if (isSubmitting) return; // Prevent multiple submissions
        isSubmitting = true; // Set flag to true to prevent duplicate submissions

        const form = document.getElementById('multiStepForm');
        const formData = new FormData(form);
        const formObject = {};
        // const errorMessage = document.getElementById('error-message');
        formData.forEach((value, key) => formObject[key] = value);
   

        axios.post('/api/customer-info', formObject)
            .then(response => {
                showSuccessAlert('Account creation successful!', 'success');
                form.reset();
                currentSection = 1;
                document.querySelector('.section.active').classList.remove('active');
                document.getElementById(`section${currentSection}`).classList.add('active');
                updateButtons();
                isSubmitting = false; // Reset flag
            })
            .catch(error => {
                console.error('Error:', error.response ? error.response.data : error.message);
                showFailureAlert(
                    error.response && error.response.data.errors
                        ? Object.values(error.response.data.errors).flat().join(' ')
                        : `Account Creation failed. Please try again.`
                        //  : `Account Creation failed. Please try again. ${userName}`
                );
                isSubmitting = false; // Reset flag
            });
    }

    document.addEventListener('DOMContentLoaded', () => {
        for (let i = 1; i <= totalSections; i++) {
            const nextButton = document.getElementById(`nextButton${i}`);
            const prevButton = document.getElementById(`prevButton${i}`);
            if (nextButton) nextButton.addEventListener('click', showNextSection);
            if (prevButton) prevButton.addEventListener('click', showPreviousSection);
        }
        document.getElementById('submitButton').addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default form submit action
            submitForm();
        });
        document.getElementById('multiStepForm').addEventListener('submit', (event) => {
            event.preventDefault();
            submitForm();
        });

        document.getElementById(`section${currentSection}`).classList.add('active');
        updateButtons();
    });
</script>


 <!-- javascript -->
<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>













