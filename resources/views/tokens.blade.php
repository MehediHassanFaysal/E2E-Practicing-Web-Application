<!-- resources/views/tokens.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tokens</title>
    <!-- Include Bootstrap CSS if needed -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <h2>User Tokens</h2>

        <!-- Display tokens -->
        @if($tokens->isEmpty())
            <p>No tokens found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Created At</th>
                        <th>Last Used At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tokens as $token)
                        <tr>
                            <td>{{ $token->token }}</td>
                            <td>{{ $token->created_at }}</td>
                            <td>{{ $token->last_used_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Include Bootstrap JS and dependencies if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
