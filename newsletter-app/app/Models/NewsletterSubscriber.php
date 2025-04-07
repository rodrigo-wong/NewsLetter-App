<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
        'frequency',
        'percentage_alert',
        'btc',
        'eth',
        'doge',
        'ltc',
        'xrp',
        'bch',
        'bnb',
        'eos',
        'ada',
        'dot',
    ];
}
