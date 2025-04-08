<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cryptocurrency Newsletter Sign-up</title>
    <!-- Bootstrap CSS (using CDN for Bootstrap 5) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (optional) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Sign Up for the Cryptocurrency Newsletter</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/signup">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name (required):</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail Address (required):</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Newsletter Frequency (required):</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frequency" id="freqMinute" value="minute" {{ old('frequency') == 'minute' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="freqMinute">
                                        Every minute
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frequency" id="freqHour" value="hour" {{ old('frequency') == 'hour' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="freqHour">
                                        Every hour
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="frequency" id="freqDaily" value="daily" {{ old('frequency') == 'daily' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="freqDaily">
                                        Daily at midnight
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Cryptocurrency Tickers (choose any):</label>
                                @php
                                    $tickers = ['BTC', 'ETH', 'DOGE', 'LTC', 'XRP', 'BCH', 'BNB', 'EOS', 'ADA', 'DOT'];
                                @endphp
                                <div class="row">
                                    @foreach ($tickers as $ticker)
                                        <div class="col-4 col-md-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tickers[]" id="ticker{{ $ticker }}" value="{{ $ticker }}"
                                                    {{ is_array(old('tickers')) && in_array($ticker, old('tickers')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ticker{{ $ticker }}">{{ $ticker }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="percentage_alert" class="form-label">Percentage Change Alert (required, numeric > 1):</label>
                                <input type="text" name="percentage_alert" id="percentage_alert" class="form-control" value="{{ old('percentage_alert') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Captcha:</label>
                                <!-- Added a wrapper with the class "captcha" so jQuery can target it -->
                                <div class="d-flex align-items-center mb-2 captcha">
                                    <span class="me-2">{!! captcha_img() !!}</span>
                                    <button type="button" id="reload" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-arrow-clockwise"></i> Reload Captcha
                                    </button>
                                </div>
                                <input type="text" name="captcha" class="form-control" placeholder="Enter Captcha">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div> 

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
