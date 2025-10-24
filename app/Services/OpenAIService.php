<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\WasteManagementPlan;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIService
{
    /**
     * Generate a waste management plan using OpenAI GPT-4o-mini with streaming for better performance
     */
    public function generateWasteManagementPlan(WasteManagementPlan $plan): string
    {
        // Check if API key is configured
        if (empty(config('openai.api_key'))) {
            throw new Exception('OpenAI API ključ nije konfigurisan. Molimo kontaktirajte administratora.');
        }
        
        try {
            $prompt = $this->buildPrompt($plan);
            
            Log::info('Starting OpenAI API request for plan generation', [
                'company_name' => $plan->company_name,
                'waste_types_count' => count($plan->waste_types)
            ]);
            
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
                'stream' => false,
            ]);

            Log::info('OpenAI API request completed successfully');

            if (isset($response->choices[0]->message->content)) {
                $content = $response->choices[0]->message->content;
                Log::info('Plan generated successfully', ['content_length' => strlen($content)]);
                return $content;
            } else {
                Log::error('OpenAI API returned empty response');
                throw new Exception('AI servis je vratio prazan odgovor. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage(), [
                'error_code' => $e->getCode(),
                'error_type' => get_class($e),
                'full_error' => $e->getTraceAsString()
            ]);
            
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
        // Check if API key is configured
        if (empty(config('openai.api_key'))) {
            throw new Exception('OpenAI API ključ nije konfigurisan. Molimo kontaktirajte administratora.');
        }
        
        try {
            $prompt = $this->buildDetailedPrompt($data);
            
            Log::info('Starting OpenAI API request for detailed plan generation', [
                'company_name' => $data['naziv_firme'] ?? 'Unknown',
                'pib' => $data['pib'] ?? 'Unknown'
            ]);
            
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
                'stream' => false,
            ]);

            Log::info('OpenAI API request completed successfully');

            if (isset($response->choices[0]->message->content)) {
                $content = $response->choices[0]->message->content;
                Log::info('Plan generated successfully', ['content_length' => strlen($content)]);
                return $content;
            } else {
                Log::error('OpenAI API returned empty response');
                throw new Exception('AI servis je vratio prazan odgovor. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error (Detailed): ' . $e->getMessage(), [
                'error_code' => $e->getCode(),
                'error_type' => get_class($e)
            ]);
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'Operation timed out') !== false) {
                throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
            } else {
                throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
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
        
        $prompt = "Napiši OPEŠŽAN, DETALJAN i PROFESIONALAN plan upravljanja otpadom za firmu koja posluje u Republici Srbiji. Plan mora biti najmanje 25 strana teksta i u potpunosti usklađen sa svim važećim zakonima i propisima Republike Srbije.\n\n";
        
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: " . $plan->company_name . "\n";
        $prompt .= "Adresa: " . $plan->company_address . "\n";
        $prompt .= "Delatnost: " . $plan->business_activity . "\n";
        $prompt .= "Tipovi otpada: " . $wasteTypesString . "\n";
        $prompt .= "Količine otpada (kg mesečno): " . $wasteAmountsString . "\n";
        $prompt .= "Ugovor sa operaterom: " . $hasOperatorContract . "\n";
        $prompt .= "Napomene: " . ($plan->notes ?? 'Nema napomena') . "\n\n";

        $prompt .= "PRAVNI OKVIR:\n";
        $prompt .= "Plan mora biti usklađen sa:\n";
        $prompt .= "- Zakonom o upravljanju otpadom (\"Službeni glasnik RS\", br. 36/2009, 88/2010, 14/2016, 95/2018, 35/2021)\n";
        $prompt .= "- Pravilnikom o upravljanju otpadom koji nastaje u industriji (\"Službeni glasnik RS\", br. 25/2019)\n";
        $prompt .= "- Pravilnikom o obrascima evidencije i godišnjem izveštaju o upravljanju otpadom (\"Službeni glasnik RS\", br. 93/2019)\n";
        $prompt .= "- Uredbom o kategorijama otpada, testiranju i klasifikaciji otpada (\"Službeni glasnik RS\", br. 56/2010, 93/2019, 25/2020)\n";
        $prompt .= "- Zakonom o zaštiti životne sredine\n";
        $prompt .= "- Relevantnim delovima EU Direktive 2008/98/EC o otpadu\n\n";

        $prompt .= "STRUKTURA PLANA - OBAVEZNO POGLAVLJE PO POGLAVLJE:\n\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV\n";
        $prompt .= "   - Pravni osnov za izradu plana\n";
        $prompt .= "   - Ciljevi i zadaci plana\n";
        $prompt .= "   - Odgovornosti i kompetencije\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "2. OPIS FIRME I LOKACIJE\n";
        $prompt .= "   - Naziv firme, PIB, adresa registracije\n";
        $prompt .= "   - Opis delatnosti i proizvodnih procesa\n";
        $prompt .= "   - Broj zaposlenih i organizaciona struktura\n";
        $prompt .= "   - Lokacija postrojenja i prostorni raspored\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "3. POSTOJEĆI SISTEM UPRAVLJANJA OTPADOM\n";
        $prompt .= "   - Trenutno stanje upravljanja otpadom\n";
        $prompt .= "   - Identifikovani problemi i nedostaci\n";
        $prompt .= "   - Potrebne izmene i poboljšanja\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "4. VRSTE OTPADA KOJE NASTAJU\n";
        $prompt .= "   - Detaljna lista svih vrsta otpada\n";
        $prompt .= "   - TABELA sa EWC kodovima, opisom i količinama\n";
        $prompt .= "   - Karakteristike i opasnosti otpada\n";
        $prompt .= "   - Mesto nastajanja otpada\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + obavezne tabele\n\n";
        
        $prompt .= "5. NAČIN RAZDVAJANJA, SKLADIŠTENJA I OZNAČAVANJA OTPADA\n";
        $prompt .= "   - Metode razdvajanja otpada na mestu nastajanja\n";
        $prompt .= "   - Skladištenje i privremeno čuvanje\n";
        $prompt .= "   - Označavanje i etiketiranje kontejnera\n";
        $prompt .= "   - Bezbednosne mere i zaštita radnika\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + konkretni primeri\n\n";
        
        $prompt .= "6. PREDAJA OTPADA I UGOVORENI OPERATERI\n";
        $prompt .= "   - Lista ugovorenih operatera za svaki tip otpada\n";
        $prompt .= "   - TABELA sa podacima o operaterima (naziv, adresa, dozvole)\n";
        $prompt .= "   - Frekvencija i način predaje otpada\n";
        $prompt .= "   - Ugovorni odnosi i obaveze\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + obavezne tabele\n\n";
        
        $prompt .= "7. EVIDENCIJE I IZVEŠTAVANJE (OBRASCI DNE I GDE)\n";
        $prompt .= "   - Evidencija otpada (Obrazac DNE)\n";
        $prompt .= "   - Godišnji izveštaj (Obrazac GDE)\n";
        $prompt .= "   - Odgovorni za vođenje evidencije\n";
        $prompt .= "   - Arhiviranje dokumenata\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + konkretni primeri\n\n";
        
        $prompt .= "8. MERE ZA SMANJENJE I PREVENCIJU OTPADA\n";
        $prompt .= "   - Strategija smanjenja količine otpada\n";
        $prompt .= "   - Mogućnosti ponovne upotrebe\n";
        $prompt .= "   - Reciklaža i prerada\n";
        $prompt .= "   - Ekonomski aspekti\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "9. PROCENA RIZIKA PO ŽIVOTNU SREDINU\n";
        $prompt .= "   - Identifikacija rizika po životnu sredinu\n";
        $prompt .= "   - Mere zaštite i prevencije\n";
        $prompt .= "   - Plan reagovanja u slučaju nesreće\n";
        $prompt .= "   - Monitoring i kontrola\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "10. ZAKLJUČAK I PREPORUKE\n";
        $prompt .= "    - Rezime implementiranih mera\n";
        $prompt .= "    - Preporuke za unapređenje\n";
        $prompt .= "    - Plan kontinuiranog poboljšanja\n";
        $prompt .= "    - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "DODATNI ZAHTEVI:\n";
        $prompt .= "- Generiši REALNE količine otpada na osnovu delatnosti firme\n";
        $prompt .= "- Navedi KONKRETNE PRIMERE operatera iz Srbije\n";
        $prompt .= "- Uključi detaljne PROCEDURE evidencije\n";
        $prompt .= "- Ako firma koristi hemikalije, elektronski otpad, ambalažu ili generiše opasan otpad, OBAVEZNO uključi posebne mere u skladu sa propisima\n";
        $prompt .= "- Koristi FORMALNI, STRUČNI TON kao u zvaničnim dokumentima\n";
        $prompt .= "- Piši na SRPSKOM JEZIKU\n";
        $prompt .= "- Rezultat mora biti spreman za direktan eksport u PDF i predaju Agenciji za zaštitu životne sredine\n\n";
        
        $prompt .= "VAŽNO: Plan mora biti opsežan, detaljan i profesionalan - minimum 25 strana teksta sa svim potrebnim tabelama, primjerima i procedurama.";

        return $prompt;
    }

    /**
     * Build optimized detailed prompt for OpenAI API based on form data
     */
    private function buildDetailedPrompt(array $data): string
    {
        $prompt = "Napiši OPEŠŽAN, DETALJAN i PROFESIONALAN plan upravljanja otpadom za firmu koja posluje u Republici Srbiji. Plan mora biti najmanje 25 strana teksta i u potpunosti usklađen sa svim važećim zakonima i propisima Republike Srbije.\n\n";
        
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: " . $data['naziv_firme'] . "\n";
        $prompt .= "PIB: " . $data['pib'] . "\n";
        $prompt .= "Delatnost: " . $data['delatnost'] . "\n";
        $prompt .= "Lokacija postrojenja: " . $data['lokacija'] . "\n";
        $prompt .= "Vrste otpada koje nastaju: " . $data['vrste_otpada'] . "\n";
        $prompt .= "Način zbrinjavanja: " . $data['nacin_zbrinjavanja'] . "\n\n";

        $prompt .= "PRAVNI OKVIR:\n";
        $prompt .= "Plan mora biti usklađen sa:\n";
        $prompt .= "- Zakonom o upravljanju otpadom (\"Službeni glasnik RS\", br. 36/2009, 88/2010, 14/2016, 95/2018, 35/2021)\n";
        $prompt .= "- Pravilnikom o upravljanju otpadom koji nastaje u industriji (\"Službeni glasnik RS\", br. 25/2019)\n";
        $prompt .= "- Pravilnikom o obrascima evidencije i godišnjem izveštaju o upravljanju otpadom (\"Službeni glasnik RS\", br. 93/2019)\n";
        $prompt .= "- Uredbom o kategorijama otpada, testiranju i klasifikaciji otpada (\"Službeni glasnik RS\", br. 56/2010, 93/2019, 25/2020)\n";
        $prompt .= "- Zakonom o zaštiti životne sredine\n";
        $prompt .= "- Relevantnim delovima EU Direktive 2008/98/EC o otpadu\n\n";

        $prompt .= "STRUKTURA PLANA - OBAVEZNO POGLAVLJE PO POGLAVLJE:\n\n";
        $prompt .= "1. UVOD I PRAVNI OSNOV\n";
        $prompt .= "   - Pravni osnov za izradu plana\n";
        $prompt .= "   - Ciljevi i zadaci plana\n";
        $prompt .= "   - Odgovornosti i kompetencije\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "2. OPIS FIRME I LOKACIJE\n";
        $prompt .= "   - Naziv firme, PIB, adresa registracije\n";
        $prompt .= "   - Opis delatnosti i proizvodnih procesa\n";
        $prompt .= "   - Broj zaposlenih i organizaciona struktura\n";
        $prompt .= "   - Lokacija postrojenja i prostorni raspored\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "3. POSTOJEĆI SISTEM UPRAVLJANJA OTPADOM\n";
        $prompt .= "   - Trenutno stanje upravljanja otpadom\n";
        $prompt .= "   - Identifikovani problemi i nedostaci\n";
        $prompt .= "   - Potrebne izmene i poboljšanja\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "4. VRSTE OTPADA KOJE NASTAJU\n";
        $prompt .= "   - Detaljna lista svih vrsta otpada\n";
        $prompt .= "   - TABELA sa EWC kodovima, opisom i količinama\n";
        $prompt .= "   - Karakteristike i opasnosti otpada\n";
        $prompt .= "   - Mesto nastajanja otpada\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + obavezne tabele\n\n";
        
        $prompt .= "5. NAČIN RAZDVAJANJA, SKLADIŠTENJA I OZNAČAVANJA OTPADA\n";
        $prompt .= "   - Metode razdvajanja otpada na mestu nastajanja\n";
        $prompt .= "   - Skladištenje i privremeno čuvanje\n";
        $prompt .= "   - Označavanje i etiketiranje kontejnera\n";
        $prompt .= "   - Bezbednosne mere i zaštita radnika\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + konkretni primeri\n\n";
        
        $prompt .= "6. PREDAJA OTPADA I UGOVORENI OPERATERI\n";
        $prompt .= "   - Lista ugovorenih operatera za svaki tip otpada\n";
        $prompt .= "   - TABELA sa podacima o operaterima (naziv, adresa, dozvole)\n";
        $prompt .= "   - Frekvencija i način predaje otpada\n";
        $prompt .= "   - Ugovorni odnosi i obaveze\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + obavezne tabele\n\n";
        
        $prompt .= "7. EVIDENCIJE I IZVEŠTAVANJE (OBRASCI DNE I GDE)\n";
        $prompt .= "   - Evidencija otpada (Obrazac DNE)\n";
        $prompt .= "   - Godišnji izveštaj (Obrazac GDE)\n";
        $prompt .= "   - Odgovorni za vođenje evidencije\n";
        $prompt .= "   - Arhiviranje dokumenata\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa + konkretni primeri\n\n";
        
        $prompt .= "8. MERE ZA SMANJENJE I PREVENCIJU OTPADA\n";
        $prompt .= "   - Strategija smanjenja količine otpada\n";
        $prompt .= "   - Mogućnosti ponovne upotrebe\n";
        $prompt .= "   - Reciklaža i prerada\n";
        $prompt .= "   - Ekonomski aspekti\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "9. PROCENA RIZIKA PO ŽIVOTNU SREDINU\n";
        $prompt .= "   - Identifikacija rizika po životnu sredinu\n";
        $prompt .= "   - Mere zaštite i prevencije\n";
        $prompt .= "   - Plan reagovanja u slučaju nesreće\n";
        $prompt .= "   - Monitoring i kontrola\n";
        $prompt .= "   - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "10. ZAKLJUČAK I PREPORUKE\n";
        $prompt .= "    - Rezime implementiranih mera\n";
        $prompt .= "    - Preporuke za unapređenje\n";
        $prompt .= "    - Plan kontinuiranog poboljšanja\n";
        $prompt .= "    - Minimum 3-5 detaljnih pasusa\n\n";
        
        $prompt .= "DODATNI ZAHTEVI:\n";
        $prompt .= "- Generiši REALNE količine otpada na osnovu delatnosti firme\n";
        $prompt .= "- Navedi KONKRETNE PRIMERE operatera iz Srbije\n";
        $prompt .= "- Uključi detaljne PROCEDURE evidencije\n";
        $prompt .= "- Ako firma koristi hemikalije, elektronski otpad, ambalažu ili generiše opasan otpad, OBAVEZNO uključi posebne mere u skladu sa propisima\n";
        $prompt .= "- Koristi FORMALNI, STRUČNI TON kao u zvaničnim dokumentima\n";
        $prompt .= "- Piši na SRPSKOM JEZIKU\n";
        $prompt .= "- Rezultat mora biti spreman za direktan eksport u PDF i predaju Agenciji za zaštitu životne sredine\n\n";
        
        $prompt .= "VAŽNO: Plan mora biti opsežan, detaljan i profesionalan - minimum 25 strana teksta sa svim potrebnim tabelama, primjerima i procedurama.";

        return $prompt;
    }

    /**
     * Generate complete waste management plan in one API call - OPTIMIZED
     */
    public function generateCompletePlan(string $prompt): string
    {
        // Check if API key is configured
        if (empty(config('openai.api_key'))) {
            throw new Exception('OpenAI API ključ nije konfigurisan. Molimo kontaktirajte administratora.');
        }
        
        try {
            Log::info('Starting OpenAI API request for complete plan generation');
            
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Ti si stručnjak za upravljanje otpadom u Republici Srbiji. Generišeš kompletne planove upravljanja otpadom za firme na srpskom jeziku, u skladu sa zakonima RS. Generišiš detaljne, profesionalne planove sa svim potrebnim poglavljima.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 6000, // Optimized for complete plan
                'temperature' => 0.7,
                'stream' => false,
            ]);

            Log::info('OpenAI API request completed successfully for complete plan');

            if (isset($response->choices[0]->message->content)) {
                $content = $response->choices[0]->message->content;
                Log::info('Complete plan generated successfully', ['content_length' => strlen($content)]);
                return $content;
            } else {
                Log::error('OpenAI API returned empty response for complete plan');
                throw new Exception('AI servis je vratio prazan odgovor za kompletan plan. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error (Complete Plan): ' . $e->getMessage(), [
                'error_code' => $e->getCode(),
                'error_type' => get_class($e),
                'full_error' => $e->getTraceAsString()
            ]);
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'Operation timed out') !== false) {
                throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
            } else {
                throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('OpenAI Connection Error (Complete Plan): ' . $e->getMessage());
            throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('OpenAI Request Error (Complete Plan): ' . $e->getMessage());
            throw new Exception('Greška u komunikaciji sa AI servisom. Molimo pokušajte ponovo.');
        } catch (Exception $e) {
            Log::error('OpenAI General Error (Complete Plan): ' . $e->getMessage());
            throw new Exception('Neočekivana greška prilikom generisanja kompletnog plana. Molimo pokušajte ponovo ili kontaktirajte podršku.');
        }
    }

    /**
     * Generate single chapter content
     */
    public function generateChapter(string $prompt): string
    {
        // Check if API key is configured
        if (empty(config('openai.api_key'))) {
            throw new Exception('OpenAI API ključ nije konfigurisan. Molimo kontaktirajte administratora.');
        }
        
        try {
            Log::info('Starting OpenAI API request for chapter generation');
            
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Ti si stručnjak za upravljanje otpadom u Republici Srbiji. Generišeš detaljne poglavlja planova upravljanja otpadom za firme na srpskom jeziku, u skladu sa zakonima RS.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 2000, // Optimized for single chapters
                'temperature' => 0.7,
                'stream' => false,
            ]);

            Log::info('OpenAI API request completed successfully for chapter');

            if (isset($response->choices[0]->message->content)) {
                $content = $response->choices[0]->message->content;
                Log::info('Chapter generated successfully', ['content_length' => strlen($content)]);
                return $content;
            } else {
                Log::error('OpenAI API returned empty response for chapter');
                throw new Exception('AI servis je vratio prazan odgovor za poglavlje. Molimo pokušajte ponovo.');
            }
            
        } catch (\OpenAI\Exceptions\ErrorException $e) {
            Log::error('OpenAI API Error (Chapter): ' . $e->getMessage(), [
                'error_code' => $e->getCode(),
                'error_type' => get_class($e),
                'full_error' => $e->getTraceAsString()
            ]);
            
            if (strpos($e->getMessage(), 'timeout') !== false || strpos($e->getMessage(), 'Operation timed out') !== false) {
                throw new Exception('AI servis je prekoračio vreme čekanja. Molimo pokušajte ponovo.');
            } elseif (strpos($e->getMessage(), 'rate_limit') !== false || strpos($e->getMessage(), 'quota') !== false) {
                throw new Exception('AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.');
            } elseif (strpos($e->getMessage(), 'connection') !== false || strpos($e->getMessage(), 'network') !== false) {
                throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
            } else {
                throw new Exception('Greška prilikom korišćenja AI servisa. Molimo pokušajte ponovo.');
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('OpenAI Connection Error (Chapter): ' . $e->getMessage());
            throw new Exception('Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('OpenAI Request Error (Chapter): ' . $e->getMessage());
            throw new Exception('Greška u komunikaciji sa AI servisom. Molimo pokušajte ponovo.');
        } catch (Exception $e) {
            Log::error('OpenAI General Error (Chapter): ' . $e->getMessage());
            throw new Exception('Neočekivana greška prilikom generisanja poglavlja. Molimo pokušajte ponovo ili kontaktirajte podršku.');
        }
    }
}
