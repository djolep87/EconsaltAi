<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\WasteManagementPlan;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIService
{
    /**
     * Generate a waste management plan using OpenAI GPT-4o-mini
     */
    public function generateWasteManagementPlan(WasteManagementPlan $plan): string
    {
        try {
            $prompt = $this->buildPrompt($plan);
            
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Ti si stručnjak za upravljanje otpadom i ekologiju u Republici Srbiji. Generišeš detaljne, profesionalne planove upravljanja otpadom za firme na srpskom jeziku, u skladu sa Zakonom o upravljanju otpadom Republike Srbije.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 3000,
                'temperature' => 0.7,
            ]);

            return $response->choices[0]->message->content ?? 'Greška prilikom generisanja plana.';
        } catch (Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            throw new Exception('Greška prilikom korišćenja AI servisa: ' . $e->getMessage());
        }
    }

    /**
     * Build the prompt for OpenAI based on plan data
     */
    private function buildPrompt(WasteManagementPlan $plan): string
    {
        $wasteTypes = $plan->waste_types;
        $quantities = $plan->waste_quantities;
        $wasteTypeLabels = WasteManagementPlan::getAvailableWasteTypes();
        
        // Build waste types string
        $wasteTypesString = '';
        foreach ($wasteTypes as $type) {
            $label = $wasteTypeLabels[$type];
            $wasteTypesString .= $label . ', ';
        }
        $wasteTypesString = rtrim($wasteTypesString, ', ');
        
        // Build waste amounts string
        $wasteAmountsString = '';
        foreach ($wasteTypes as $type) {
            $label = $wasteTypeLabels[$type];
            $quantity = $quantities[$type] ?? 0;
            $wasteAmountsString .= $label . ': ' . $quantity . ' kg/mesečno, ';
        }
        $wasteAmountsString = rtrim($wasteAmountsString, ', ');

        $hasOperatorContract = $plan->has_contract_with_operator ? 'Da' : 'Ne';
        
        $prompt = "Napiši kompletan plan upravljanja otpadom za firmu na osnovu sledećih podataka:\n\n";
        $prompt .= "Naziv firme: {{" . $plan->company_name . "}}\n";
        $prompt .= "Adresa: {{" . $plan->company_address . "}}\n";
        $prompt .= "Delatnost: {{" . $plan->business_activity . "}}\n";
        $prompt .= "Tipovi otpada: {{" . $wasteTypesString . "}}\n";
        $prompt .= "Procena količina otpada (kg mesečno): {{" . $wasteAmountsString . "}}\n";
        $prompt .= "Ima ugovor sa operaterom: {{" . $hasOperatorContract . "}}\n";
        $prompt .= "Napomene: {{" . ($plan->notes ?? 'Nema napomena') . "}}\n\n";

        $prompt .= "Plan treba da bude usklađen sa Zakonom o upravljanju otpadom Republike Srbije i da sadrži sledeće sekcije:\n";
        $prompt .= "1. Uvod i osnovni podaci o firmi\n";
        $prompt .= "2. Vrste i količine otpada koje firma generiše\n";
        $prompt .= "3. Način privremenog skladištenja otpada\n";
        $prompt .= "4. Način odvoza i predaje operaterima\n";
        $prompt .= "5. Moguće mere za smanjenje količine otpada\n";
        $prompt .= "6. Evidenciju i izveštavanje o otpadu\n";
        $prompt .= "7. Zaključak\n\n";
        
        $prompt .= "Piši stručno, formalno i pregledno. Koristi podnaslove i numeraciju.\n";
        $prompt .= "Tekst treba da bude razumljiv i spreman za štampu u PDF formatu.";

        return $prompt;
    }
}
