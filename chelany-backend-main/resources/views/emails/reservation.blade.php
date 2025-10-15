<!DOCTYPE html>
<html>
<head>
    <title>
        @if($type == 'owner')
            New Reservation - Chelany Restaurant
        @else
            Reservation Confirmation - Chelany Restaurant
        @endif
    </title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; color: #333; }
        .container { padding: 20px; background: white; max-width: 600px; margin: auto; border: 1px solid #ddd; border-radius: 8px; }
        h2 { color: #d9230f; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #555; width: 30%; }
    </style>
</head>
<body>
    <div class="container">
        @if($type == 'owner')
            <h2>New Reservation at Chelany Restaurant</h2>
            <p>You’ve received a new reservation. Details are below:</p>
        @else
            <h2>Thank you for your reservation, {{ $data['name'] }}!</h2>
            <p>Your reservation details are as follows:</p>
        @endif

        <table>
            <tr><td class="label">Name</td><td>{{ $data['name'] }}</td></tr>
            <tr><td class="label">Email</td><td>{{ $data['email'] }}</td></tr>
            <tr><td class="label">Phone</td><td>{{ $data['phone'] }}</td></tr>
            <tr><td class="label">Date</td><td>{{ $data['date'] }}</td></tr>
            <tr><td class="label">Time</td><td>{{ $data['time'] }}</td></tr>
            <tr><td class="label">Guests</td><td>{{ $data['guests'] }}</td></tr>
            <tr><td class="label">Message</td><td>{{ $data['message'] ?? 'N/A' }}</td></tr>
        </table>

        @if($type == 'owner')
            <p style="margin-top: 20px;">Please prepare for the reservation. Thanks,<br><strong>Chelany Restaurant</strong></p>
        @else
            <p style="margin-top: 20px;">We look forward to welcoming you!<br><strong>Chelany Restaurant</strong></p>
        @endif
    </div>
</body>
</html>
