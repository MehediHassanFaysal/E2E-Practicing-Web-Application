<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Withdraw Transaction History | {{ $loginUser->name }} </title>
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
        .form-group textarea {
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
        #transaction-history-table {
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 12px;
        min-width: 600px;
    }

        #transaction-history-table thead {
            background-color: #f2f2f2;
            color: #333;
        }

        #transaction-history-table th, #transaction-history-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        #transaction-history-table th {
            background-color: #4CAF50;
            color: white;
        }

        #transaction-history-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #transaction-history-table tr:hover {
            background-color: #f1f1f1;
        }

        #transaction-history-table td {
            font-size: 11px;
        }

            
    </style>
</head>
<body>
    <div class="top-bar">
        <a href="{{ url('/landing-page') }}" style="text-decoration: none; color: white;"><h3>E2E TEST SITE</h3></a>
        <button class="toggle-btn" id="toggle-btn">☰</button>
        <div class="logout-container">
            <button class="logout-btn" id="logout-btn" >{{ $loginUser->name }} ( {{ $loginUser->member_code }} )</button>
            <div class="logout-dropdown" id="logout-dropdown">
                <a href="{{ route('userProfile', ['session_id' => $sessionId]) }}" >Profile</a>
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
        <a href="#withdraw">Cash Withdraw</a>
        <a href="{{ route('fund.transfer', ['session_id' => $sessionId]) }}">Fund Transfer</a>
        <a href="#history">Transaction History</a>
        <ul class="submenu">
            <li><a href="{{ route('simple-transaction.history', ['session_id' => $sessionId]) }}">Cash Deposit Transactions</a></li>
            <li><a href="#withdraw">Cash Withdraw Transactions</a></li>
            <li><a href="{{ route('fund-transaction.history', ['session_id' => $sessionId]) }}">Fund Transactions</a></li>
        </ul>
    </div>
    
    <div class="content" id="content">
        <h4> Cash Withdraw Transaction History </h4>
        <br>
        <form id="fund-trans-history-form">
            @csrf
            <input type="text" id="account_number" name="sender_account_number" placeholder="Account Number">
            <button 
                type="submit" 
                style="padding: 3px 20px; border: 1px solid black; border-radius: 5px; background-color: #eaeded; color: black; font-size: 11px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#28b463'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor='#f9e79f'; this.style.transform='scale(1)';"
            >
                Search
            </button>
            <button 
                type="reset" 
                style="padding: 3px 22px; border: 1px solid black; border-radius: 5px; background-color: #eaeded; color: black; font-size: 11px; cursor: pointer;"
                onmouseover="this.style.backgroundColor='#e74c3c'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor='#3498db'; this.style.transform='scale(1)';"
            >
                Clear
            </button>
        </form>
    
        <br>
            <table id="transaction-history-table" border="1" style="width: 90%; display: none;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>Create Date-Time</th>
                        <th>Update Date-Time</th>



                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted here by JavaScript -->
                </tbody>
            </table>
    </div>


<script>
    document.getElementById('fund-trans-history-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const accountNumber = document.getElementById('account_number').value;
        const table = document.getElementById('transaction-history-table');
        const tbody = table.querySelector('tbody');

        // Construct the URL with the account number
        const url = `/api/simple-withdraw-transaction-history/${encodeURIComponent(accountNumber)}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json().then(data => {
            if (response.ok) {
                showSuccessAlert('Withdraw Transaction History Fetched Successfully!', 'success');

                // Clear the table body
                tbody.innerHTML = '';
                 // Sort transactions in descending order based on created_at
                 data.transactions.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                // Populate the table with transaction data
                data.transactions.forEach(transaction => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${transaction.id}</td>
                        <td>${transaction.amount}</td>
                        <td>${transaction.remarks}</td>
                        <td>${transaction.created_at}</td>
                        <td>${transaction.updated_at}</td>

                    `;
                    tbody.appendChild(row);
                });

                // Show the table
                table.style.display = 'table';
            } else {
                console.error('Failed to Fetch Withdraw Transaction History with Status:', response.status);
                showFailureAlert(
                    data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : 'Failed to Fetch Withdraw Transaction History or, Account Not Mathced. Please try again.',
                    'error'
                );
            }
        }))
        .catch(error => {
            console.error('Error:', error);
            showFailureAlert('Failed to fetch transaction history. Please try again.', 'error');
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
