<?php

namespace App\Http\Controllers;

use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class WastePlanController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Generate waste management plan using OpenAI API
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        try {
            // Validate input data
            $validator = Validator::make($request->all(), [
                'naziv_firme' => 'required|string|max:255',
                'pib' => 'required|string|max:20',
                'delatnost' => 'required|string|max:255',
                'lokacija' => 'required|string|max:255',
                'vrste_otpada' => 'required|string',
                'nacin_zbrinjavanja' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Extract validated data
            $data = $validator->validated();

            // Generate plan using OpenAI service
            $plan = $this->openAIService->generateDetailedWastePlan($data);

            return response()->json([
                'success' => true,
                'message' => 'Plan upravljanja otpadom je uspešno generisan',
                'data' => [
                    'plan' => $plan,
                    'firma' => [
                        'naziv' => $data['naziv_firme'],
                        'pib' => $data['pib'],
                        'delatnost' => $data['delatnost'],
                        'lokacija' => $data['lokacija']
                    ],
                    'generated_at' => now()->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (Exception $e) {
            Log::error('WastePlanController::generate - Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Greška prilikom generisanja plana: ' . $e->getMessage()
            ], 500);
        }
    }
}
