<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    /**
     * Show subscription page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('subscription.index', [
            'user' => $user,
            'subscription' => $user->subscription('default') ?? null,
            'trialEndsAt' => $user->trial_ends_at,
            'onTrial' => $user->onTrial(),
            'subscribed' => $user->subscribed(),
        ]);
    }

    /**
     * Create subscription checkout session
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        
        if ($user->subscribed()) {
            return redirect()->route('subscription.index')
                ->with('info', 'Već imate aktivnu pretplatu.');
        }

        try {
            $priceId = env('STRIPE_PRICE_ID_MONTHLY', 'price_monthly');
            
            $checkout = $user->newSubscription('default', $priceId)
                ->checkout([
                    'success_url' => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('subscription.canceled'),
                    'payment_method_types' => ['card'],
                    'billing_address_collection' => 'required',
                    'line_items' => [[
                        'price' => $priceId,
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'allow_promotion_codes' => true,
                    'subscription_data' => [
                        'trial_period_days' => $user->onTrial() ? 0 : 7,
                        'metadata' => [
                            'user_id' => $user->id,
                        ],
                    ],
                ]);

            return redirect($checkout->url);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Greška prilikom kreiranja checkout sesije: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful subscription
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('subscription.index')
                ->with('error', 'Nije pronađena checkout sesija.');
        }

        try {
            $user = Auth::user();
            $session = \Stripe\StripeClient::make(config('cashier.secret'))->checkout->sessions->retrieve($sessionId);
            
            if ($session->payment_status === 'paid') {
                return redirect()->route('dashboard')
                    ->with('success', 'Vaša pretplata je uspešno aktivirana!');
            }
            
            return redirect()->route('subscription.index')
                ->with('info', 'Vaša pretplata se obrađuje.');
        } catch (\Exception $e) {
            return redirect()->route('subscription.index')
                ->with('error', 'Greška prilikom verifikacije pretplate.');
        }
    }

    /**
     * Handle canceled subscription
     */
    public function canceled()
    {
        return redirect()->route('subscription.index')
            ->with('info', 'Registracija pretplate je otkazana. Možete da pokušate ponovo.');
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->subscribed()) {
            return redirect()->back()
                ->with('error', 'Nemate aktivnu pretplatu za otkazivanje.');
        }

        try {
            $subscription = $user->subscription('default');
            $subscription->cancel();

            return redirect()->back()
                ->with('success', 'Vaša pretplata je otkazana. Imaćete pristup do kraja trenutnog perioda.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Greška prilikom otkazivanja pretplate: ' . $e->getMessage());
        }
    }

    /**
     * Resume subscription
     */
    public function resume(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->subscription('default') || !$user->subscription('default')->onGracePeriod()) {
            return redirect()->back()
                ->with('error', 'Nemate pretplatu koja može biti nastavljena.');
        }

        try {
            $user->subscription('default')->resume();

            return redirect()->back()
                ->with('success', 'Vaša pretplata je uspešno nastavljena!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Greška prilikom nastavljanja pretplate: ' . $e->getMessage());
        }
    }

    /**
     * Show billing portal
     */
    public function billing(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        try {
            $billingPortal = $user->billingPortalUrl(route('subscription.index'));
            return redirect($billingPortal);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Greška prilikom pristupanja billing portalu.');
        }
    }
}
