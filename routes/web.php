<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WasteManagementPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $plans = $user->wasteManagementPlans()->latest()->take(5)->get();
    return view('dashboard', compact('plans', 'user'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Waste Management Plans routes
    Route::resource('plans', WasteManagementPlanController::class);
    Route::post('/plans/{plan}/generate', [WasteManagementPlanController::class, 'generate'])->name('plans.generate');
    Route::get('/plans/{plan}/pdf', [WasteManagementPlanController::class, 'pdf'])->name('plans.pdf');
    Route::get('/plans/{plan}/pdf-view', [WasteManagementPlanController::class, 'pdfView'])->name('plans.pdf.view');
    
    // Subscription routes
    Route::prefix('subscription')->name('subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/checkout', [SubscriptionController::class, 'checkout'])->name('checkout');
        Route::get('/success', [SubscriptionController::class, 'success'])->name('success');
        Route::get('/canceled', [SubscriptionController::class, 'canceled'])->name('canceled');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
        Route::get('/billing', [SubscriptionController::class, 'billing'])->name('billing');
    });
});

// Stripe Webhook
Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

require __DIR__.'/auth.php';
