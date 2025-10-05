<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send OTP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Enter Your Email</h2>
        <form id="otpForm" action="{{ route('send.otp') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Send OTP</button>
        </form>

        <div id="countdown" class="mt-3"></div>

        <div id="verifySection" class="mt-3" style="display:none;">
            <h3>Verify OTP</h3>
            <form id="verifyForm" action="{{ route('verify.otp') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="otp">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" required>
                </div>
                <button type="submit" class="btn btn-success">Verify OTP</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('otpForm').onsubmit = function (e) {
            e.preventDefault();
            const email = document.getElementById('email').value;

            fetch('{{ route('send.otp') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById('verifySection').style.display = 'block';
                    startCountdown();
                } else {
                    alert('Error sending OTP.');
                }
            });
        };

        function startCountdown() {
            const otpExpiresAt = new Date(Date.now() + 5 * 60 * 1000).getTime();

            const countdown = setInterval(() => {
                const now = new Date().getTime();
                const distance = otpExpiresAt - now;

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(countdown);
                    document.getElementById("countdown").innerHTML = "EXPIRED";
                    document.getElementById('verifySection').style.display = 'none';
                }
            }, 1000);
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
