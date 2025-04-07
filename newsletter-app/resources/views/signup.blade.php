<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cryptocurrency Newsletter Sign-up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Sign Up for the Cryptocurrency Newsletter</h1>

    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/signup">
        @csrf

        <label>Name (required):</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br><br>

        <label>E-mail Address (required):</label><br>
        <input type="text" name="email" value="{{ old('email') }}"><br><br>

        <label>Newsletter Frequency (required):</label><br>
        <input type="radio" name="frequency" value="minute" {{ old('frequency') == 'minute' ? 'checked' : '' }}> Every minute<br>
        <input type="radio" name="frequency" value="hour" {{ old('frequency') == 'hour' ? 'checked' : '' }}> Every hour<br>
        <input type="radio" name="frequency" value="daily" {{ old('frequency') == 'daily' ? 'checked' : '' }}> Daily at midnight<br><br>

        <label>Cryptocurrency Tickers (choose any):</label><br>
        @php
            $tickers = ['BTC', 'ETH', 'DOGE', 'LTC', 'XRP', 'BCH', 'BNB', 'EOS', 'ADA', 'DOT'];
        @endphp
        @foreach ($tickers as $ticker)
            <input type="checkbox" name="tickers[]" value="{{ $ticker }}"
                {{ is_array(old('tickers')) && in_array($ticker, old('tickers')) ? 'checked' : '' }}>
            {{ $ticker }}<br>
        @endforeach
        <br>

        <label>Percentage Change Alert (required, numeric > 1):</label><br>
        <input type="text" name="percentage_alert" value="{{ old('percentage_alert') }}"><br><br>

        <label>Captcha:</label><br>
        <div class="captcha">
            <span>{!! captcha_img() !!}</span>
            <button type="button" id="reload">Reload Captcha</button>
        </div>
        <input type="text" name="captcha" placeholder="Enter Captcha"><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <script type="text/javascript">
        $('#reload').click(function(){
            $.ajax({
                type: 'GET',
                url: '/reload-captcha',
                success: function(data){
                    $('.captcha span').html(data.captcha);
                }
            });
        });
    </script>
</body>
</html>
