<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentsController extends Controller
{
    public function pay(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $token = request('stripeToken');
        $email = request('stripeEmail'); 
        $charge = Charge::create([
            'amount' => 1000,
            'currency' => 'mxn',
            'description' => 'Test Neru',
            'source' => $token,
        ]);
 
        return $email.'<--Success-->'.$token;
    }
}
