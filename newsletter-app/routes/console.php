<?php

use App\Mail\NewsletterMail;
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
    $subscribers = \App\Models\NewsletterSubscriber::where('frequency', $frequency)->get();

    // Fetch cryptocurrency data from the Coinlore API
    $response = \Illuminate\Support\Facades\Http::get('https://api.coinlore.net/api/tickers/');
    $data = $response->json();
    $cryptos = collect($data['data']);

    foreach ($subscribers as $subscriber) {
        // Build an array of rows for the newsletter table.
        $rows = [];

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
                    
                    $rows[] = [
                        'symbol'        => $crypto['symbol'],
                        'price'         => $price,
                        'percentChange' => $percentChange,
                        'bgColor'       => $bgColor,
                    ];
                }
            }
        }

        $unsubscribeUrl = route('unsubscribe', ['id' => $subscriber->id]);

        // Send the newsletter using the mailable, passing the raw data.
        Mail::to($subscriber->email)
            ->send(new NewsletterMail($rows, $unsubscribeUrl));
    }
}
