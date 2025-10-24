<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\WasteManagementPlanController;
use App\Http\Controllers\WastePlanController;
use App\Http\Controllers\PlanGeneratorController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api-test', function () {
    return view('api-test');
});

// Plan Generator routes (authenticated only)
Route::middleware('auth')->group(function () {
    Route::get('/plan-generator', [PlanGeneratorController::class, 'showForm'])->name('plan.generator');
    Route::post('/plan-generate', [PlanGeneratorController::class, 'generatePlan'])->name('plan.generate');
    Route::get('/plan/download/{filename}', [PlanGeneratorController::class, 'downloadPlan'])->name('plan.download');
});

Route::get('/dashboard', function () {
    /** @var User|null $user */
    $user = Auth::user();
    if ($user) {
        $plans = $user->wasteManagementPlans()->latest()->take(5)->get();
    } else {
        $plans = collect();
    }
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
    
    // API routes for plan generation
    Route::post('/generate-plan', [WastePlanController::class, 'generate'])->name('api.generate-plan');
});

// Stripe Webhook
Route::post('/stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

require __DIR__.'/auth.php';
