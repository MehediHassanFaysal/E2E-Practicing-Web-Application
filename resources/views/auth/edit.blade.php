<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Include Bootstrap CSS if needed -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2>Edit User</h2>
        
        <!-- Display validation errors -->
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
         @endif
        
        <!-- Edit User Form -->
        <form action="{{ route('users.update', ['id' => $user->id, 'session_id' => $sessionId]) }}" method="PUT">
            @csrf
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <input type="text" class="form-control" id="user_type" name="user_type" value="{{ old('user_type', $user->user_type) }}" required disabled>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and dependencies if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script> 
    // Get session ID from a global variable or meta tag
    const sessionId = "{{ session()->getId() }}"; // Embedding session ID in JavaScript
</script>
</body>
</html>