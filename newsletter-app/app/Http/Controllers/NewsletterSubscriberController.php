<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class NewsletterSubscriberController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function processSignup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'frequency' => 'required|in:minute,hour,daily',
            'percentage_alert' => 'required|numeric|min:1.01',
            'captcha' => 'required|captcha',
        ], [
            'captcha.captcha' => 'The captcha is incorrect, please try again.',
        ]);

        $subscriber = NewsletterSubscriber::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'frequency' => $validated['frequency'],
            'percentage_alert' => $validated['percentage_alert'],
            'btc' => in_array('BTC', $request->input('tickers', [])),
            'eth' => in_array('ETH', $request->input('tickers', [])),
            'doge' => in_array('DOGE', $request->input('tickers', [])),
            'ltc' => in_array('LTC', $request->input('tickers', [])),
            'xrp' => in_array('XRP', $request->input('tickers', [])),
            'bch' => in_array('BCH', $request->input('tickers', [])),
            'bnb' => in_array('BNB', $request->input('tickers', [])),
            'eos' => in_array('EOS', $request->input('tickers', [])),
            'ada' => in_array('ADA', $request->input('tickers', [])),
            'dot' => in_array('DOT', $request->input('tickers', [])),
        ]);

        return view('signup_success');
    }

    public function unsubscribe($id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->delete();
        return view('unsubscribe_success');
    }
}
