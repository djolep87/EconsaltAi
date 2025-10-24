<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Services\OpenAIService;
use App\Services\PlanGeneratorService;
use App\Models\WasteManagementPlan;
use Exception;

class PlanGeneratorController extends Controller
{
    protected $openAIService;
    protected $planGeneratorService;

    public function __construct()
    {
        $this->openAIService = app(OpenAIService::class);
        $this->planGeneratorService = app(PlanGeneratorService::class);
    }

    /**
     * Prikaži formu za generisanje plana
     */
    public function showForm()
    {
        return view('plan-generator.form');
    }

    /**
     * Generiši kompletan plan upravljanja otpadom
     */
    public function generatePlan(Request $request)
    {
        Log::info('PlanGeneratorController::generatePlan called', [
            'method' => $request->method(),
            'url' => $request->url(),
            'request_data' => $request->all(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        
        // Postavi timeout za plan generisanje
        set_time_limit(300); // 5 minuta maksimalno
        
        try {

            // Validacija podataka
            $validatedData = $request->validate([
                'naziv_firme' => 'required|string|max:255',
                'pib' => 'required|string|max:20',
                'delatnost' => 'required|string|max:255',
                'adresa' => 'required|string|max:500',
                'vrste_otpada' => 'required|string',
                'nacin_skladistenja' => 'required|string',
                'operateri' => 'required|string',
                'broj_zaposlenih' => 'nullable|integer|min:1',
                'povrsina_objekta' => 'nullable|numeric|min:0',
                'napomene' => 'nullable|string|max:1000',
            ]);

            Log::info('Validation passed, starting plan generation', ['company' => $validatedData['naziv_firme']]);

            // Generiši plan sa timeout handling
            $startTime = microtime(true);
            $finalniPlan = $this->planGeneratorService->generateCompletePlan($validatedData);
            $generationTime = microtime(true) - $startTime;

            Log::info('Plan content generated', [
                'content_length' => strlen($finalniPlan),
                'generation_time' => round($generationTime, 2) . ' seconds'
            ]);

            // Generiši PDF
            $pdfStartTime = microtime(true);
            $pdfPath = $this->generatePDF($finalniPlan, $validatedData['naziv_firme']);
            $pdfTime = microtime(true) - $pdfStartTime;

            Log::info('PDF generated successfully', [
                'pdf_path' => $pdfPath,
                'pdf_generation_time' => round($pdfTime, 2) . ' seconds'
            ]);

            // Sačuvaj plan u bazi podataka ako je korisnik ulogovan
            $planId = null;
            if (Auth::check()) {
                $plan = $this->savePlanToDatabase($validatedData, $finalniPlan, $pdfPath);
                $planId = $plan->id;
                Log::info('Plan saved to database', ['plan_id' => $planId]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Plan je uspešno generisan!',
                'pdf_url' => Storage::url($pdfPath),
                'download_url' => route('plan.download', ['filename' => basename($pdfPath)]),
                'plan_id' => $planId,
                'dashboard_url' => Auth::check() ? route('plans.show', $planId) : null,
                'generation_time' => round($generationTime, 2)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Podaci nisu ispravni. Molimo proverite sva polja.',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Plan generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            // Specifične greške za različite tipove problema
            $errorMessage = 'Došlo je do greške pri generisanju plana.';
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'timed out') !== false) {
                $errorMessage = 'Generisanje plana je prekoračilo vreme čekanja. Molimo pokušajte ponovo.';
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                $errorMessage = 'AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.';
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                $errorMessage = 'Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.';
            } elseif (strpos($e->getMessage(), 'API ključ') !== false) {
                $errorMessage = 'Problem sa konfiguracijom AI servisa. Molimo kontaktirajte administratora.';
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Sačuvaj plan u bazi podataka
     */
    private function savePlanToDatabase($validatedData, $aiPlan, $pdfPath)
    {
        // Parsiraj vrste otpada iz stringa
        $wasteTypes = $this->parseWasteTypes($validatedData['vrste_otpada']);
        
        // Kreiraj plan u bazi
        $plan = WasteManagementPlan::create([
            'user_id' => Auth::id(),
            'company_name' => $validatedData['naziv_firme'],
            'company_address' => $validatedData['adresa'],
            'business_activity' => $validatedData['delatnost'],
            'pib' => $validatedData['pib'],
            'broj_zaposlenih' => $validatedData['broj_zaposlenih'] ?? null,
            'povrsina_objekta' => $validatedData['povrsina_objekta'] ?? null,
            'vrste_otpada' => $validatedData['vrste_otpada'],
            'nacin_skladistenja' => $validatedData['nacin_skladistenja'],
            'operateri' => $validatedData['operateri'],
            'waste_types' => $wasteTypes,
            'waste_quantities' => $this->generateDefaultQuantities($wasteTypes),
            'has_contract_with_operator' => !empty($validatedData['operateri']),
            'notes' => $validatedData['napomene'] ?? null,
            'ai_generated_plan' => $aiPlan,
            'status' => 'generated'
        ]);

        return $plan;
    }

    /**
     * Parsiraj vrste otpada iz stringa
     */
    private function parseWasteTypes($wasteTypesString)
    {
        $availableTypes = WasteManagementPlan::getAvailableWasteTypes();
        $detectedTypes = [];
        
        $wasteTypesString = strtolower($wasteTypesString);
        
        foreach ($availableTypes as $key => $label) {
            $labelLower = strtolower($label);
            if (strpos($wasteTypesString, $labelLower) !== false || 
                strpos($wasteTypesString, $key) !== false) {
                $detectedTypes[] = $key;
            }
        }
        
        // Ako nije detektovano ništa, dodaj osnovne tipove
        if (empty($detectedTypes)) {
            $detectedTypes = ['papir', 'plastika'];
        }
        
        return $detectedTypes;
    }

    /**
     * Generiši default količine za detektovane tipove otpada
     */
    private function generateDefaultQuantities($wasteTypes)
    {
        $quantities = [];
        foreach ($wasteTypes as $type) {
            $quantities[$type] = rand(50, 500); // Random količina između 50-500 kg
        }
        return $quantities;
    }

    /**
     * Generiši PDF dokument
     */
    private function generatePDF($content, $companyName)
    {
        try {
            // Kreiraj direktorijum ako ne postoji
            $directory = 'plans';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Generiši PDF
            $pdf = PDF::loadView('pdf.plan-template', [
                'content' => $content,
                'companyName' => $companyName,
                'generatedAt' => now()
            ]);

            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
            ]);

            // Sačuvaj PDF
            $filename = 'plan-upravljanja-otpadom-' . 
                       \Illuminate\Support\Str::slug($companyName, '-') . '-' . 
                       now()->format('Y-m-d-H-i-s') . '.pdf';

            $pdfPath = $directory . '/' . $filename;
            Storage::put($pdfPath, $pdf->output());

            Log::info('PDF generated successfully', ['path' => $pdfPath]);

            return $pdfPath;

        } catch (Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            throw new Exception('Greška pri generisanju PDF-a: ' . $e->getMessage());
        }
    }

    /**
     * Preuzmi generisani PDF
     */
    public function downloadPlan($filename)
    {
        try {
            $filePath = 'plans/' . $filename;
            
            if (!Storage::exists($filePath)) {
                abort(404, 'Fajl nije pronađen.');
            }

            return Storage::download($filePath);

        } catch (Exception $e) {
            Log::error('PDF download failed: ' . $e->getMessage());
            abort(500, 'Greška pri preuzimanju fajla.');
        }
    }
}
