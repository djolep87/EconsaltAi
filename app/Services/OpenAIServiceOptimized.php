<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\WasteManagementPlan;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIServiceOptimized
{
    /**
     * Generate a waste management plan using OpenAI GPT-4o-mini with optimized settings
     */
    public function generateWasteManagementPlan(WasteManagementPlan $plan): string
    {
        $maxRetries = 2;
        $retryCount = 0;
        
        while ($retryCount < $maxRetries) {
            try {
                $prompt = $this->buildPrompt($plan);
                
                $response = OpenAI::chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Ti si stručnjak za upravljanje otpadom u Republici Srbiji. Generišeš detaljne planove upravljanja otpadom za firme na srpskom jeziku, u skladu sa zakonima RS.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 3000, // Reduced for faster response
                    'temperature' => 0.7,
                    'timeout' => 60, // Reduced timeout to 1 minute
                ]);

                if (isset($response->choices[0]->message->content)) {
                    return $response->choices[0]->message->content;
                } else {
                    throw new Exception('AI servis je vratio prazan odgovor.');
                }
                
            } catch (Exception $e) {
                $retryCount++;
                Log::warning("OpenAI API attempt {$retryCount} failed: " . $e->getMessage());
                
                if ($retryCount >= $maxRetries) {
                    if (strpos($e->getMessage(), 'timeout') !== false) {
                        throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
                    } elseif (strpos($e->getMessage(), 'rate_limit') !== false) {
                        throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
                    } else {
                        throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
                    }
                }
                
                // Wait before retry
                sleep(2);
            }
        }
        
        // This should never be reached, but added for completeness
        throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
    }

    /**
     * Generate detailed waste management plan using OpenAI GPT-4o-mini for API
     */
    public function generateDetailedWastePlan(array $data): string
    {
        $maxRetries = 2;
        $retryCount = 0;
        
        while ($retryCount < $maxRetries) {
            try {
                $prompt = $this->buildDetailedPrompt($data);
                
                $response = OpenAI::chat()->create([
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Ti si stručnjak za upravljanje otpadom u Republici Srbiji. Generišeš detaljne planove upravljanja otpadom za firme na srpskom jeziku, u skladu sa zakonima RS.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 3000, // Reduced for faster response
                    'temperature' => 0.7,
                    'timeout' => 60, // Reduced timeout to 1 minute
                ]);

                if (isset($response->choices[0]->message->content)) {
                    return $response->choices[0]->message->content;
                } else {
                    throw new Exception('AI servis je vratio prazan odgovor.');
                }
                
            } catch (Exception $e) {
                $retryCount++;
                Log::warning("OpenAI API attempt {$retryCount} failed: " . $e->getMessage());
                
                if ($retryCount >= $maxRetries) {
                    if (strpos($e->getMessage(), 'timeout') !== false) {
                        throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
                    } elseif (strpos($e->getMessage(), 'rate_limit') !== false) {
                        throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
                    } else {
                        throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
                    }
                }
                
                // Wait before retry
                sleep(2);
            }
        }
        
        // This should never be reached, but added for completeness
        throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
    }

    /**
     * Build optimized prompt for OpenAI based on plan data
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
        
        $prompt = "Napiši detaljan plan upravljanja otpadom za firmu u Republici Srbiji u skladu sa zakonima.\n\n";
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: " . $plan->company_name . "\n";
        $prompt .= "Adresa: " . $plan->company_address . "\n";
        $prompt .= "Delatnost: " . $plan->business_activity . "\n";
        $prompt .= "Tipovi otpada: " . $wasteTypesString . "\n";
        $prompt .= "Količine otpada: " . $wasteAmountsString . "\n";
        $prompt .= "Ugovor sa operaterom: " . $hasOperatorContract . "\n";
        $prompt .= "Napomene: " . ($plan->notes ?? 'Nema napomena') . "\n\n";

        $prompt .= "STRUKTURA PLANA:\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV\n";
        $prompt .= "2. OPIS FIRME I LOKACIJE\n";
        $prompt .= "3. POSTOJEĆI SISTEM UPRAVLJANJA OTPADOM\n";
        $prompt .= "4. VRSTE OTPADA KOJE NASTAJU (sa tabelama)\n";
        $prompt .= "5. RAZDVAJANJE I SKLADIŠTENJE OTPADA\n";
        $prompt .= "6. UGOVORENI OPERATERI\n";
        $prompt .= "7. EVIDENCIJE I IZVEŠTAVANJE (DNE i GDE)\n";
        $prompt .= "8. MERE ZA SMANJENJE OTPADA\n";
        $prompt .= "9. PROCENA RIZIKA PO ŽIVOTNU SREDINU\n";
        $prompt .= "10. ZAKLJUČAK I PREPORUKE\n\n";
        
        $prompt .= "ZAHTEVI:\n";
        $prompt .= "- Minimum 2-3 pasusa po poglavlju\n";
        $prompt .= "- Tabele gde je potrebno\n";
        $prompt .= "- Formalni ton, srpski jezik\n";
        $prompt .= "- Spreman za PDF i predaju Agenciji za zaštitu životne sredine";

        return $prompt;
    }

    /**
     * Build optimized wasted prompt for OpenAI API based on form data
     */
    private function buildDetailedPrompt(array $data): string
    {
        $prompt = "Napiši detaljan plan upravljanja otpadom za firmu u Republici Srbiji u skladu sa zakonima.\n\n";
        
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: " . $data['naziv_firme'] . "\n";
        $prompt .= "PIB: " . $data['pib'] . "\n";
        $prompt .= "Delatnost: " . $data['delatnost'] . "\n";
        $prompt .= "Lokacija: " . $data['lokacija'] . "\n";
        $prompt .= "Vrste otpada: " . $data['vrste_otpada'] . "\n";
        $prompt .= "Način zbrinjavanja: " . $data['nacin_zbrinjavanja'] . "\n\n";

        $prompt .= "STRUKTURA PLANA:\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV\n";
        $prompt .= "2. OPIS FIRME I LOKACIJE\n";
        $prompt .= "3. POSTOJEĆI SISTEM UPRAVLJANJA OTPADOM\n";
        $prompt .= "4. VRSTE OTPADA KOJE NASTAJU (sa tabelama)\n";
        $prompt .= "5. RAZDVAJANJE I SKLADIŠTENJE OTPADA\n";
        $prompt .= "6. UGOVORENI OPERATERI\n";
        $prompt .= "7. EVIDENCIJE I IZVEŠTAVANJE (DNE i GDE)\n";
        $prompt .= "8. MERE ZA SMANJENJE OTPADA\n";
        $prompt .= "9. PROCENA RIZIKA PO ŽIVOTNU SREDINU\n";
        $prompt .= "10. ZAKLJUČAK I PREPORUKE\n\n";
        
        $prompt .= "ZAHTEVI:\n";
        $prompt .= "- Minimum 2-3 pasusa po poglavlju\n";
        $prompt .= "- Tabele gde je potrebno\n";
        $prompt .= "- Formalni ton, srpski jezik\n";
        $prompt .= "- Spreman za PDF i predaju Agenciji za zaštitu životne sredine";

        return $prompt;
    }
}
