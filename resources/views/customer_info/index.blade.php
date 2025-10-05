<!-- resources/views/customer_info/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Info List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Customer Information List</h1>
    <a href="{{ route('customer-info.create') }}">Add New Customer Info</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Member Code</th>
                <th>Mobile Number</th>
                <th>Occupation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customerInfos as $customerInfo)
                <tr>
                    <td>{{ $customerInfo->id }}</td>
                    <td>{{ $customerInfo->member_code }}</td>
                    <td>{{ $customerInfo->mobile_number }}</td>
                    <td>{{ $customerInfo->occupation }}</td>
                    <td>
                        <a href="{{ route('customer-info.show', $customerInfo->id) }}">View</a>
                        <a href="{{ route('customer-info.edit', $customerInfo->id) }}">Edit</a>
                        <form action="{{ route('customer-info.destroy', $customerInfo->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
