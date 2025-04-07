<?php

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function() {
    sendNewsletter('daily');
})
->daily()
->at('08:00')
->timezone('America/New_York')
->name('send-daily-newsletter')
->description('Send daily cryptocurrency newsletter to subscribers');

Schedule::call(function() {
    sendNewsletter('hour');
})
->hourly()
->timezone('America/New_York')
->name('send-hourly-newsletter')
->description('Send hourly cryptocurrency newsletter to subscribers');

Schedule::call(function() {
    sendNewsletter('minute');
})
->everyMinute()
->timezone('America/New_York')
->name('send-minute-newsletter')
->description('Send minute cryptocurrency newsletter to subscribers');

function sendNewsletter($frequency)
{
    $subscribers = NewsletterSubscriber::where('frequency', $frequency)->get();

    $response = Http::get('https://api.coinlore.net/api/tickers/');
    $data = $response->json();
    $cryptos = collect($data['data']);

    foreach ($subscribers as $subscriber) {
        $tableRows = '';

        foreach (['btc', 'eth', 'doge', 'ltc', 'xrp', 'bch', 'bnb', 'eos', 'ada', 'dot'] as $ticker) {
            if ($subscriber->$ticker) {
                $crypto = $cryptos->firstWhere('symbol', strtoupper($ticker));
                if ($crypto) {
                    $price = $crypto['price_usd'];
                    $percentChange = $crypto['percent_change_1h'];
                    $bgColor = '';
                    if ($percentChange >= $subscriber->percentage_alert) {
                        $bgColor = 'green';
                    } elseif ($percentChange <= -$subscriber->percentage_alert) {
                        $bgColor = 'red';
                    }
                    $tableRows .= "<tr style='background-color: {$bgColor};'>
                            <td>{$crypto['symbol']}</td>
                            <td>\${$price}</td>
                            <td>{$percentChange}%</td>
                        </tr>";
                }
            }
        }

        $unsubscribeUrl = route('unsubscribe', ['id' => $subscriber->id]);
        $emailBody = "
                <h2>Cryptocurrency Newsletter</h2>
                <table border='1' cellpadding='5'>
                    <thead>
                        <tr>
                            <th>Ticker</th>
                            <th>Price (USD)</th>
                            <th>1h % Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        {$tableRows}
                    </tbody>
                </table>
                <p><a href='{$unsubscribeUrl}'>Unsubscribe</a></p>
            ";

            Mail::send([], [], function ($message) use ($subscriber, $emailBody) {
                $message->to($subscriber->email)
                    ->subject('Your Cryptocurrency Newsletter')
                    ->html($emailBody);
            });
            
    }
}
