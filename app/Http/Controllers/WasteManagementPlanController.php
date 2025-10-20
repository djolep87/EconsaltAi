<?php

namespace App\Http\Controllers;

use App\Models\WasteManagementPlan;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;

class WasteManagementPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Auth::user()->wasteManagementPlans()->latest()->get();
        
        return view('plans.index', [
            'plans' => $plans,
            'wasteTypes' => WasteManagementPlan::getAvailableWasteTypes()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('plans.create', [
            'wasteTypes' => WasteManagementPlan::getAvailableWasteTypes()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'business_activity' => 'required|string|max:255',
            'waste_types' => 'required|array|min:1',
            'waste_types.*' => 'in:papir,plastika,metal,staklo,elektronski,opasan',
            'waste_quantities' => 'required|array',
            'waste_quantities.*' => 'numeric|min:0',
            'has_contract_with_operator' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $plan = Auth::user()->wasteManagementPlans()->create([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'business_activity' => $request->business_activity,
            'waste_types' => $request->waste_types,
            'waste_quantities' => $request->waste_quantities,
            'has_contract_with_operator' => (bool) $request->has_contract_with_operator,
            'notes' => $request->notes,
            'status' => 'draft',
        ]);

        return redirect()->route('plans.show', $plan->id)
            ->with('success', 'Plan je uspešno kreiran. Sada možete generisati AI plan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = Auth::user()->wasteManagementPlans()->findOrFail($id);
        
        return view('plans.show', [
            'plan' => $plan,
            'wasteTypes' => WasteManagementPlan::getAvailableWasteTypes()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Auth::user()->wasteManagementPlans()->findOrFail($id);
        
        return view('plans.edit', [
            'plan' => $plan,
            'wasteTypes' => WasteManagementPlan::getAvailableWasteTypes()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = Auth::user()->wasteManagementPlans()->findOrFail($id);
        
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'business_activity' => 'required|string|max:255',
            'waste_types' => 'required|array|min:1',
            'waste_types.*' => 'in:papir,plastika,metal,staklo,elektronski,opasan',
            'waste_quantities' => 'required|array',
            'waste_quantities.*' => 'numeric|min:0',
            'has_contract_with_operator' => 'required|boolean',
            'notes' => 'nullable|string',
        ]);

        $plan->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'business_activity' => $request->business_activity,
            'waste_types' => $request->waste_types,
            'waste_quantities' => $request->waste_quantities,
            'has_contract_with_operator' => (bool) $request->has_contract_with_operator,
            'notes' => $request->notes,
        ]);

        return redirect()->route('plans.show', $plan->id)
            ->with('success', 'Plan je uspešno ažuriran.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Auth::user()->wasteManagementPlans()->findOrFail($id);
        $plan->delete();

        return redirect()->route('plans.index')
            ->with('success', 'Plan je uspešno obrisan.');
    }

    /**
     * Generate AI plan for the specified resource.
     */
    public function generate(WasteManagementPlan $plan)
    {
        // Check if user owns the plan
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            // Check if user has active subscription or trial
            $user = Auth::user();
            if (!$user->onTrial() && !$user->subscribed()) {
                return redirect()->route('plans.show', $plan->id)
                    ->with('error', 'Morate imati aktivnu pretplatu da biste generisali AI plan.');
            }

            // Update status to generating
            $plan->update(['status' => 'generating']);

            // Generate AI plan using OpenAI service
            $openAIService = new OpenAIService();
            $aiPlan = $openAIService->generateWasteManagementPlan($plan);

            // Update plan with generated content
            $plan->update([
                'status' => 'generated',
                'ai_generated_plan' => $aiPlan
            ]);

            return redirect()->route('plans.show', $plan->id)
                ->with('success', 'AI plan je uspešno generisan!');

        } catch (Exception $e) {
            // Reset status to draft if generation fails
            $plan->update(['status' => 'draft']);

            return redirect()->route('plans.show', $plan->id)
                ->with('error', 'Greška prilikom generisanja AI plana: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF for the specified resource.
     */
    public function pdf(WasteManagementPlan $plan)
    {
        // Check if user owns the plan
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$plan->ai_generated_plan) {
            return redirect()->route('plans.show', $plan->id)
                ->with('error', 'Plan mora biti generisan pre preuzimanja PDF-a.');
        }

        try {
            // Prepare data for PDF
            $wasteTypes = WasteManagementPlan::getAvailableWasteTypes();
            
            // Generate PDF using Dompdf
            $pdf = PDF::loadView('pdf.waste-management-plan', [
                'plan' => $plan,
                'wasteTypes' => $wasteTypes
            ]);

            // Configure PDF options
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
            ]);

            // Generate filename
            $filename = 'plan-upravljanja-otpadom-' . 
                       Str::slug($plan->company_name, '-') . '-' . 
                       $plan->created_at->format('Y-m-d') . '.pdf';

            // Update plan status to completed after successful PDF generation
            if ($plan->status !== 'completed') {
                $plan->update(['status' => 'completed']);
            }

            // Return PDF download
            return $pdf->download($filename);

        } catch (Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            
            return redirect()->route('plans.show', $plan->id)
                ->with('error', 'Greška prilikom generisanja PDF-a: ' . $e->getMessage());
        }
    }

    /**
     * View PDF for the specified resource in browser.
     */
    public function pdfView(WasteManagementPlan $plan)
    {
        // Check if user owns the plan
        if ($plan->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$plan->ai_generated_plan) {
            return redirect()->route('plans.show', $plan->id)
                ->with('error', 'Plan mora biti generisan pre prikazivanja PDF-a.');
        }

        try {
            // Prepare data for PDF
            $wasteTypes = WasteManagementPlan::getAvailableWasteTypes();
            
            // Generate PDF using Dompdf
            $pdf = PDF::loadView('pdf.waste-management-plan', [
                'plan' => $plan,
                'wasteTypes' => $wasteTypes
            ]);

            // Configure PDF options
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
            ]);

            // Generate filename
            $filename = 'plan-upravljanja-otpadom-' . 
                       Str::slug($plan->company_name, '-') . '-' . 
                       $plan->created_at->format('Y-m-d') . '.pdf';

            // Return PDF stream for viewing in browser
            return $pdf->stream($filename);

        } catch (Exception $e) {
            Log::error('PDF View Error: ' . $e->getMessage());
            
            return redirect()->route('plans.show', $plan->id)
                ->with('error', 'Greška prilikom prikazivanja PDF-a: ' . $e->getMessage());
        }
    }
}
