<!-- resources/views/customer_info/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer Info</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Add New Customer Information</h1>
    <form action="{{ route('customer-info.store') }}" method="POST">
        @csrf
        <div>
            <label for="member_code">Member Code</label>
            <input type="text" id="member_code" name="member_code" value="{{ old('member_code') }}">
            @error('member_code')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="mobile_number">Mobile Number</label>
            <input type="text" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}">
            @error('mobile_number')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="occupation">Occupation</label>
            <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}">
            @error('occupation')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="present_address">Present Address</label>
            <textarea id="present_address" name="present_address">{{ old('present_address') }}</textarea>
            @error('present_address')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="permanent_address">Permanent Address</label>
            <textarea id="permanent_address" name="permanent_address">{{ old('permanent_address') }}</textarea>
            @error('permanent_address')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="nation_id_card">Nation ID Card</label>
            <input type="text" id="nation_id_card" name="nation_id_card" value="{{ old('nation_id_card') }}">
            @error('nation_id_card')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="nominee_code">Nominee Code</label>
            <input type="text" id="nominee_code" name="nominee_code" value="{{ old('nominee_code') }}">
            @error('nominee_code')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="account_number">Account Number</label>
            <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}">
            @error('account_number')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="account_type">Account Type</label>
            <input type="text" id="account_type" name="account_type" value="{{ old('account_type') }}">
            @error('account_type')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Save</button>
    </form>
    <a href="{{ route('customer-info.index') }}">Back to List</a>
</body>
</html>
