<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\WasteManagementPlan;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIServiceStreaming
{
    /**
     * Generate a waste management plan using OpenAI GPT-4o-mini with streaming for better performance
     */
    public function generateWasteManagementPlan(WasteManagementPlan $plan): string
    {
        try {
            $prompt = $this->buildPrompt($plan);
            
            Log::info('Starting OpenAI API request for plan generation');
            
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
                'max_tokens' => 8000,
                'temperature' => 0.7,
                'timeout' => 300, // 5 minutes
            ]);

            Log::info('OpenAI API request completed successfully');

            if (isset($response->choices[0]->message->content)) {
                return $response->choices[0]->message->content;
            } else {
                Log::error('OpenAI API returned empty response');
                throw new Exception('AI servis je vratio prazan odgovor. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'Operation timed out') !== false) {
                throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
            } else {
                throw new Exception('Greška prilikom korišćenja AI servisa: ' . $e->getMessage());
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('OpenAI Request Error: ' . $e->getMessage());
            throw new Exception('Greška u komunikaciji sa AI servisom. Molimo pokušajte ponovo.');
        } catch (Exception $e) {
            Log::error('OpenAI General Error: ' . $e->getMessage());
            throw new Exception('Neočekivana greška prilikom generisanja plana. Molimo pokušajte ponovo ili kontaktirajte podršku.');
        }
    }

    /**
     * Generate detailed waste management plan using OpenAI GPT-4o-mini for API
     */
    public function generateDetailedWastePlan(array $data): string
    {
        try {
            $prompt = $this->buildDetailedPrompt($data);
            
            Log::info('Starting OpenAI API request for detailed plan generation');
            
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
                'max_tokens' => 8000,
                'temperature' => 0.7,
                'timeout' => 300, // 5 minutes
            ]);

            Log::info('OpenAI API request completed successfully');

            if (isset($response->choices[0]->message->content)) {
                return $response->choices[0]->message->content;
            } else {
                Log::error('OpenAI API returned empty response');
                throw new Exception('AI servis je vratio prazan odgovor. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error (Detailed): ' . $e->getMessage());
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'Operation timed out') !== false) {
                throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
            } else {
                throw new Exception('Greška prilikom korišćenja AI servisa: ' . $e->getMessage());
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('OpenAI Connection Error: ' . $e->getMessage());
            throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('OpenAI Request Error: ' . $e->getMessage());
            throw new Exception('Greška u komunikaciji sa AI servisom. Molimo pokušajte ponovo.');
        } catch (Exception $e) {
            Log::error('OpenAI General Error (Detailed): ' . $e->getMessage());
            throw new Exception('Neočekivana greška prilikom generisanja plana. Molimo pokušajte ponovo ili kontaktirajte podršku.');
        }
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
        
        $prompt = "Napiši OPEŠŽAN, DETALJAN plan upravljanja otpadom za firmu u Republici Srbiji. Plan mora biti najmanje 25 strana teksta i u skladu sa svim zakonima RS.\n\n";
        $prompt .= "FIRMA: " . $plan->company_name . " (" . $plan->company_address . ")\n";
        $prompt .= "DELATNOST: " . $plan->business_activity . "\n";
        $prompt .= "OTPAD: " . $wasteTypesString . " - " . $wasteAmountsString . "\n";
        $prompt .= "OPERATER: " . $hasOperatorContract . "\n";
        $prompt .= "NAPOMENE: " . ($plan->notes ?? 'Nema') . "\n\n";

        $prompt .= "OBAVEZNA POGLAVLJA (svako po 3-5 detaljnih pasusa):\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV - Zakon o upravljanju otpadom RS, ciljevi, odgovornosti\n";
        $prompt .= "2. OPIS FIRME - Naziv, PIB, delatnost, lokacija, zaposleni, organizacija\n";
        $prompt .= "3. POSTOJEĆI SISTEM - Trenutno stanje, problemi, potrebne izmene\n";
        $prompt .= "4. VRSTE OTPADA - Detaljna lista sa EWC kodovima, tabele, količine, karakteristike\n";
        $prompt .= "5. RAZDVAJANJE I SKLADIŠTENJE - Metode, označavanje, bezbednost, primeri\n";
        $prompt .= "6. UGOVORENI OPERATERI - Lista operatera, tabele, frekvencija, ugovori\n";
        $prompt .= "7. EVIDENCIJE - Obrasci DNE i GDE, procedure, arhiviranje, odgovorni\n";
        $prompt .= "8. SMANJENJE OTPADA - Strategije, reciklaža, ponovna upotreba, ekonomija\n";
        $prompt .= "9. PROCENA RIZIKA - Rizici po životnu sredinu, mere zaštite, plan reagovanja\n";
        $prompt .= "10. ZAKLJUČAK - Rezime, preporuke, plan poboljšanja\n\n";
        
        $prompt .= "KRITIČNO: Generiši DETALJAN, STRUČAN tekst sa tabelama, primjerima iz Srbije, konkretnim procedurama. Formalni ton, srpski jezik. Spreman za PDF i predaju Agenciji za zaštitu životne sredine.";

        return $prompt;
    }

    /**
     * Build optimized detailed prompt for OpenAI API based on form data
     */
    private function buildDetailedPrompt(array $data): string
    {
        $prompt = "Napiši OPEŠŽAN, DETALJAN plan upravljanja otpadom za firmu u Republici Srbiji. Plan mora biti najmanje 25 strana teksta i u skladu sa svim zakonima RS.\n\n";
        
        $prompt .= "FIRMA: " . $data['naziv_firme'] . " (PIB: " . $data['pib'] . ")\n";
        $prompt .= "DELATNOST: " . $data['delatnost'] . "\n";
        $prompt .= "LOKACIJA: " . $data['lokacija'] . "\n";
        $prompt .= "OTPAD: " . $data['vrste_otpada'] . "\n";
        $prompt .= "ZBRINJAVANJE: " . $data['nacin_zbrinjavanja'] . "\n\n";

        $prompt .= "OBAVEZNA POGLAVLJA (svako po 3-5 detaljnih pasusa):\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV - Zakon o upravljanju otpadom RS, ciljevi, odgovornosti\n";
        $prompt .= "2. OPIS FIRME - Naziv, PIB, delatnost, lokacija, zaposleni, organizacija\n";
        $prompt .= "3. POSTOJEĆI SISTEM - Trenutno stanje, problemi, potrebne izmene\n";
        $prompt .= "4. VRSTE OTPADA - Detaljna lista sa EWC kodovima, tabele, količine, karakteristike\n";
        $prompt .= "5. RAZDVAJANJE I SKLADIŠTENJE - Metode, označavanje, bezbednost, primeri\n";
        $prompt .= "6. UGOVORENI OPERATERI - Lista operatera, tabele, frekvencija, ugovori\n";
        $prompt .= "7. EVIDENCIJE - Obrasci DNE i GDE, procedure, arhiviranje, odgovorni\n";
        $prompt .= "8. SMANJENJE OTPADA - Strategije, reciklaža, ponovna upotreba, ekonomija\n";
        $prompt .= "9. PROCENA RIZIKA - Rizici po životnu sredinu, mere zaštite, plan reagovanja\n";
        $prompt .= "10. ZAKLJUČAK - Rezime, preporuke, plan poboljšanja\n\n";
        
        $prompt .= "KRITIČNO: Generiši DETALJAN, STRUČAN tekst sa tabelama, primjerima iz Srbije, konkretnim procedurama. Formalni ton, srpski jezik. Spreman za PDF i predaju Agenciji za zaštitu životne sredine.";

        return $prompt;
    }
}

