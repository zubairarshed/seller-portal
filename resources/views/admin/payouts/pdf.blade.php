<!DOCTYPE html>
<html>
<head>
    <title>Payouts Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Payouts Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Seller</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payouts as $payout)
                <tr>
                    <td>{{ $payout->created_at->format('Y-m-d') }}</td>
                    <td>{{ $payout->seller->name }}</td>
                    <td>${{ number_format($payout->amount, 2) }}</td>
                    <td>{{ ucfirst($payout->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
