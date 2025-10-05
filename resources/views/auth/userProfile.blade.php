<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $loginUser->name }}'s Profile </title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: green;
            color: white;
            padding: 0px 5px;
            z-index: 1000; /* Ensure it's above the sidebar */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar h3 {
            margin-left: 70px;
        }
        .top-bar .toggle-btn {
            position: fixed;
            top: 12.5px;
            left: 15px;
            background-color: green;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            z-index: 1;
        }




        .top-bar .logout-container {
            position: relative;
        }
        .top-bar .logout-btn {
            background-color: green;
            color: white;
            /* border: none; */
            padding: 5px 10px;
            cursor: pointer;
            z-index: 1;
            border: 1px solid #797d7f;
            margin-right: 20px;
        }
        .top-bar .logout-dropdown {
            display: none; /* Hidden by default */
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            color: black;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 2;
            width: 150px; /* Adjust as needed */
        }

        .top-bar .logout-dropdown.show {
            display: block; /* Show dropdown when .show class is added */
        }

        .top-bar .logout-dropdown a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: black;
        }

        .top-bar .logout-dropdown a:hover {
            background-color: #f0f0f0;
        }


        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: green;
            color: white;
            transition: 0.3s;
            overflow-x: hidden;
            padding-top: 60px;
        }
        .sidebar.collapsed {
            width: 0;
            padding-top: 0;
        }
        .sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 15px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: black;
        }

        .content {
            margin-left: 250px;
            padding-left: 20px;
            padding-top: 50px;
            padding-bottom: 100px;
            transition: margin-left 0.3s;
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two columns for content */
            gap: 20px; /* Space between columns */
        }
        .content.shifted {
            margin-left: 0;
        }

        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 12px;
            color: #333;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            height: 100px;
        }
        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .form-group .clear-btn {
            background-color: #6c757d;
        }
        .form-group .clear-btn:hover {
            background-color: #5a6268;
        }
        .password-container {
            display: relative; 
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
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .sidebar .submenu {
            display: none;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
         /* Show submenu when the parent link is hovered */
         .sidebar a:hover + .submenu,
        .sidebar .submenu:hover {
            display: block;
        }

        .sidebar .submenu li {
            margin: 0;
        }

        .sidebar .submenu li a {
            display: block;
            padding-left: 30px;
            text-decoration: none;
            color: #333;
            font-size: 11px;
        }

        .sidebar .submenu li a:hover {
            background-color: #ddd;
        }
		 
    </style>
</head>
<body>
    <div class="top-bar">
        <a href="{{ url('/landing-page') }}" style="text-decoration: none; color: white;"><h3>E2E TEST SITE</h3></a>
        <button class="toggle-btn" id="toggle-btn">☰</button>
        <div class="logout-container">
            <!-- Include the user profile view -->
           
            <button class="logout-btn" id="logout-btn">{{ $loginUser->name }} ({{ $loginUser->member_code }} )</button>
            <div class="logout-dropdown" id="logout-dropdown">
                <!-- <a href="#profile">Profile</a> -->
                <!-- <a href="#settings">Settings</a> -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
                <a href="#logout" id="logout-button">Logout</a>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <a href="{{ route('cash.deposit', ['session_id' => $sessionId]) }}">Cash Deposit</a>
        <a href="{{ route('cash.withdraw', ['session_id' => $sessionId]) }}">Cash Withdraw</a>
        <a href="{{ route('fund.transfer', ['session_id' => $sessionId]) }}">Fund Transfer</a>
        <a href="#history">Transaction History</a>
        <ul class="submenu">
            <li><a href="{{ route('simple-transaction.history', ['session_id' => $sessionId]) }}">Cash Deposit Transactions</a></li>
            <li><a href="{{ route('simple-withdraw-transaction.history', ['session_id' => $sessionId]) }}">Cash Withdraw Transactions</a></li>
            <li><a href="{{ route('fund-transaction.history', ['session_id' => $sessionId]) }}">Fund Transactions</a></li>
        </ul>
    </div>
    
    <div class="content" id="content">
        <div> </div>
        <div> </div>

        <div class="form-container">
            <h3> Update Profile </h3>
            
                <br>
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Name:</label>
                    <input type="text" id="username" name="username" placeholder="Customer Name" value="{{ $loginUser->name }}" disabled required>
                </div> 
                <form id="profile-update-form" action="{{ url('/api/customer-info') }}" method="POST">
                    @csrf
                    <!-- Member Code -->
                    <div class="form-group">
                        <label for="member_code">Member Code:</label>
                        <input type="text" id="member_code" name="member_code" placeholder="Member Code" value="{{ $loginUser->member_code }}" required readonly>
                    </div>

                    <!-- Mobile Number -->
                    <div class="form-group">
                        <label for="mobile_number">Mobile Number:</label>
                        <input type="tel" id="mobile_number" name="mobile_number" placeholder="Mobile Number" value="{{ $userInfo->mobile_number ?? '' }}" required>
                    </div>

                    <!-- NID Card -->
                    <div class="form-group">
                        <label for="nation_id_card">NID Number:</label>
                        <input type="text" id="nation_id_card" name="nation_id_card" placeholder="NID Card" value="{{ $userInfo->nation_id_card ?? '' }}" required>
                    </div>
                    <!-- NID Card -->
                    <div class="form-group">
                        <label for="dob">DOB:</label>
                        <input type="text" id="dob" name="dob" placeholder="Date of Birth (dd/mm/yyyy)" value="{{ $userInfo->dob ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="occupation">Occupation:</label>
                        <select id="occupation" name="occupation" required>
                            <option value="">Select User Occupation</option>
                            <option value="self_employment" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'self_employment') ? 'selected' : '' }}>Self Employment</option>
                            <option value="engineer" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'engineer') ? 'selected' : '' }}>Engineer</option>
                            <option value="doctor" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'doctor') ? 'selected' : '' }}>Doctor</option>
                            <option value="teacher" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'teacher') ? 'selected' : '' }}>Teacher</option>
                            <option value="farmer" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'farmer') ? 'selected' : '' }}>Farmer</option>
                            <option value="govt_officer" {{ (isset($userInfo->occupation) && $userInfo->occupation == 'govt_officer') ? 'selected' : '' }}>Govt. Officer</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="anual_income">Annual Income:</label>
                        <input type="number" id="anual_income" name="anual_income" value="{{ $userInfo->anual_income ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="present_address">Present Address:</label>
                        <input type="text" id="present_address" name="present_address" value="{{ $userInfo->present_address ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="permanent_address">Permanent Address:</label>
                        <input type="text" id="permanent_address" name="permanent_address" value="{{ $userInfo->permanent_address ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nominee_name">Nominee Name:</label>
                        <input type="text" id="nominee_name" name="nominee_name" value="{{ $userInfo->nominee_name ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="age">Nominee Age:</label>
                        <input type="text" id="age" name="age" value="{{ $userInfo->age ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nominee_mobile_number">Nominee Mobile Number:</label>
                        <input type="text" id="nominee_mobile_number" name="nominee_mobile_number" value="{{ $userInfo->nominee_mobile_number ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nid_number">Nominee NID Number:</label>
                        <input type="text" id="nid_number" name="nid_number" placeholder="Nominee NID Card Number" value="{{ $userInfo->nid_number ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="birth_id">Nominee Birth Certificate Number:</label>
                        <input type="text" id="birth_id" name="birth_id" value="{{ $userInfo->birth_id ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="percentage">Nominee Percentage:</label>
                        <input type="text" id="percentage" name="percentage" value="100" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="relation_with_member">Relation with Member:</label>
                        <select id="relation_with_member" name="relation_with_member" required>
                            <option value="">Select Relation With Nominee</option>
                            <option value="brother" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'brother') ? 'selected' : '' }}>Brother</option>
                            <option value="father" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'father') ? 'selected' : '' }}>Father</option>
                            <option value="mother" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'mother') ? 'selected' : '' }}>Mother</option>
                            <option value="sister" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'sister') ? 'selected' : '' }}>Sister</option>
                            <option value="daughter" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'daughter') ? 'selected' : '' }}>Daughter</option>
                            <option value="son" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'son') ? 'selected' : '' }}>Son</option>
                            <option value="wife" {{ (isset($userInfo->relation_with_member) && $userInfo->relation_with_member == 'wife') ? 'selected' : '' }}>Wife</option>
                        </select>
                    </div>
        </div>
        <div class="password-container">
        <br>
            <h3 style="color: white">.</h3>
            
                    <div class="form-group">
                        <label for="introducer_account">Introducer Account:</label>
                        <input type="text" id="introducer_account" name="introducer_account" value="{{ $userInfo->introducer_account ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="introducer_name">Introducer Name:</label>
                        <input type="text" id="introducer_name" name="introducer_name" value="{{ $userInfo->introducer_name ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="introducer_nid">Introducer NID Number:</label>
                        <input type="text" id="introducer_nid" name="introducer_nid" value="{{ $userInfo->introducer_nid ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="introducer_mobile_number">Introducer Mobile Number:</label>
                        <input type="text" id="introducer_mobile_number" name="introducer_mobile_number" value="{{ $userInfo->introducer_mobile_number ?? '' }}" required>
                    </div>

                    <!-- Account Type -->
                    <div class="form-group">
                        <label for="account_type">Account Type:</label>
                        <input type="text" id="account_type" name="account_type" value="Savings" required>
                    </div>
                    
                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" id="amount" name="amount" step="0.01" value="{{ $userInfo->amount ?? '' }}" required>
                    </div>
                    
                    <!-- Remarks -->
                    <div class="form-group">
                        <label for="remaks">Remarks:</label>
                        <textarea id="remaks" name="remaks" required>{{ $userInfo->remaks ?? '' }}</textarea>
                    </div>
<!-- 
           
                    <div class="form-group">
                        <label for="extra"></label>
                        <input id="extra" name="extra" placeholder="Extra" style="display:none;">
                    </div> -->

                    <!-- Submit and Clear Buttons -->
                    <div class="form-group">
                        <button type="submit">Update</button>
                        <button type="reset" class="clear-btn">Clear</button>
                    </div>
              </form>
              
        </div>
    </div>



    <script>
document.getElementById('profile-update-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
        
        const form = this;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json().then(data => {
            if (response.ok) {
                showSuccessAlert('Account Create/Update Successful!', 'success');

                // Clear the form fields
                form.reset();

                // Redirect to the user profile page with session ID
                const baseUrl = '/user-profile';
                const sessionId = data.session_id; // Ensure `session_id` is returned from the API response
                const redirectUrl = `${baseUrl}?session_id=${encodeURIComponent(sessionId)}`;
                window.location.href = redirectUrl;
            } else {
                console.error('Form submission failed with status:', response.status);
                showFailureAlert(
                    data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : 'Profile already updated. Thank you.',
                    'error'
                );
            }
        }))
        .catch(error => {
            console.error('Error:', error);
            showFailureAlert('Form submission failed. Please try again.', 'error');
        });
    });
</script>



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
        
        // Automatically remove the alert after 5 seconds
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
        
        // Automatically remove the alert after 5 seconds
        setTimeout(() => {
            alert.classList.remove('show');
            // Remove the alert element from the DOM
            alert.remove();
        }, 5000);
    }

</script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggle-btn');
        const content = document.getElementById('content');
        const logoutBtn = document.getElementById('logout-btn');
        const logoutDropdown = document.getElementById('logout-dropdown');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('shifted');
        });

        logoutBtn.addEventListener('click', () => {
            logoutDropdown.classList.toggle('show');
        });

        document.addEventListener('click', (event) => {
            if (!logoutBtn.contains(event.target) && !logoutDropdown.contains(event.target)) {
                logoutDropdown.classList.remove('show');
            }
        });

    </script>
    <script>
        document.getElementById('logout-button').addEventListener('click', function() {
        document.getElementById('logout-form').submit();
        });
    </script>
</body>
</html>
