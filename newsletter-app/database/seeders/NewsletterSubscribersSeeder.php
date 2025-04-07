<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsletterSubscriber;

class NewsletterSubscribersSeeder extends Seeder
{
    public function run()
    {
        NewsletterSubscriber::create([
            'name'=> 'User Minute',
            'email' => 'minute@example.com',
            'frequency' => 'minute',
            'percentage_alert' => 2.0,
            'btc' => true,
            'eth' => false,
            'doge' => true,
            'ltc' => false,
            'xrp' => false,
            'bch' => false,
            'bnb' => false,
            'eos' => false,
            'ada' => false,
            'dot' => false,
        ]);

        NewsletterSubscriber::create([
            'name' => 'User Hour',
            'email' => 'hour@example.com',
            'frequency' => 'hour',
            'percentage_alert' => 1.5,
            'btc' => true,
            'eth' => true,
            'doge'=> false,
            'ltc' => false,
            'xrp' => false,
            'bch' => false,
            'bnb' => false,
            'eos' => false,
            'ada' => false,
            'dot' => false,
        ]);

        NewsletterSubscriber::create([
            'name' => 'User Daily',
            'email' => 'daily@example.com',
            'frequency' => 'daily',
            'percentage_alert' => 3.0,
            'btc' => false,
            'eth' => true,
            'doge' => true,
            'ltc' => false,
            'xrp' => false,
            'bch' => false,
            'bnb' => false,
            'eos' => false,
            'ada' => false,
            'dot' => false,
        ]);
    }
}
