<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cryptocurrency Newsletter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border: solid 1px black;
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            padding: 5px;
            border: solid 1px black;
            text-align: left;
        }
        .unsubscribe-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Cryptocurrency Newsletter</h1>
    <p>Below are the latest cryptocurrency updates:</p>

    <table>
        <thead>
            <tr>
                <th>Ticker</th>
                <th>Price (USD)</th>
                <th>1h % Change</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr style="background-color: {{ $row['bgColor'] }}; color: {{ $row['bgColor'] ? 'white' : 'black' }};">
                    <td>{{ $row['symbol'] }}</td>
                    <td>${{ $row['price'] }}</td>
                    <td>{{ $row['percentChange'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ $unsubscribeUrl }}" class="unsubscribe-button">
            Unsubscribe
        </a>
    </p>

    <p>Thanks, CryptoNews</p>
</body>
</html>
