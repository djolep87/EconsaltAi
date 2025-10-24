<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class PlanGeneratorService
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Generiši kompletan plan upravljanja otpadom - OPTIMIZOVANA VERZIJA
     */
    public function generateCompletePlan(array $data): string
    {
        Log::info('Starting optimized plan generation', [
            'company' => $data['naziv_firme']
        ]);

        try {
            // Generiši ceo plan u jednom API pozivu
            $prompt = $this->buildCompletePlanPrompt($data);
            $plan = $this->openAIService->generateCompletePlan($prompt);
            
            Log::info('Complete plan generated successfully', [
                'content_length' => strlen($plan)
            ]);

            return $plan;

        } catch (Exception $e) {
            Log::error('Failed to generate complete plan', [
                'error' => $e->getMessage()
            ]);
            
            // Fallback na stari način ako ne uspe optimizovana verzija
            return $this->generateCompletePlanLegacy($data);
        }
    }

    /**
     * Legacy metoda za generisanje plana poglavlje po poglavlje (fallback)
     */
    private function generateCompletePlanLegacy(array $data): string
    {
        $poglavlja = $this->getPoglavlja();
        $finalniPlan = '';

        Log::info('Starting legacy plan generation', [
            'company' => $data['naziv_firme'],
            'chapters_count' => count($poglavlja)
        ]);

        foreach ($poglavlja as $index => $poglavlje) {
            try {
                Log::info("Generating chapter: {$poglavlje['naziv']}", ['index' => $index + 1]);
                
                $sadrzaj = $this->generateChapter($poglavlje, $data);
                
                if (!empty($sadrzaj)) {
                    $finalniPlan .= $this->formatChapter($poglavlje, $sadrzaj, $index + 1);
                    Log::info("Chapter generated successfully: {$poglavlje['naziv']}");
                } else {
                    Log::warning("Empty content for chapter: {$poglavlje['naziv']}");
                }

                // Kratka pauza između poglavlja
                usleep(500000); // 0.5 sekundi

            } catch (Exception $e) {
                Log::error("Failed to generate chapter: {$poglavlje['naziv']}", [
                    'error' => $e->getMessage()
                ]);
                
                // Nastavi sa sledećim poglavljem
                $finalniPlan .= $this->formatChapter($poglavlje, 
                    "Greška pri generisanju ovog poglavlja. Molimo kontaktirajte administratora.", 
                    $index + 1
                );
            }
        }

        Log::info('Legacy plan generation finished', [
            'total_length' => strlen($finalniPlan)
        ]);

        return $finalniPlan;
    }

    /**
     * Generiši pojedinačno poglavlje
     */
    private function generateChapter(array $poglavlje, array $data): string
    {
        $prompt = $this->buildChapterPrompt($poglavlje, $data);
        
        return $this->openAIService->generateChapter($prompt);
    }

    /**
     * Kreiraj optimizovani prompt za ceo plan
     */
    private function buildCompletePlanPrompt(array $data): string
    {
        $prompt = "Generiši KOMPLETAN plan upravljanja otpadom za firmu u Republici Srbiji. Plan mora biti detaljan, profesionalan i u skladu sa zakonima RS.\n\n";
        
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: {$data['naziv_firme']}\n";
        $prompt .= "PIB: {$data['pib']}\n";
        $prompt .= "Delatnost: {$data['delatnost']}\n";
        $prompt .= "Adresa: {$data['adresa']}\n";
        $prompt .= "Vrste otpada: {$data['vrste_otpada']}\n";
        $prompt .= "Način skladištenja: {$data['nacin_skladistenja']}\n";
        $prompt .= "Operateri: {$data['operateri']}\n";
        
        if (!empty($data['broj_zaposlenih'])) {
            $prompt .= "Broj zaposlenih: {$data['broj_zaposlenih']}\n";
        }
        
        if (!empty($data['povrsina_objekta'])) {
            $prompt .= "Površina objekta: {$data['povrsina_objekta']} m²\n";
        }
        
        if (!empty($data['napomene'])) {
            $prompt .= "Napomene: {$data['napomene']}\n";
        }

        $prompt .= "\nSTRUKTURA PLANA - OBAVEZNO POGLAVLJE PO POGLAVLJE:\n\n";
        
        $poglavlja = $this->getPoglavlja();
        foreach ($poglavlja as $index => $poglavlje) {
            $broj = $index + 1;
            $prompt .= "{$broj}. {$poglavlje['naziv']}\n";
            $prompt .= "   {$poglavlje['zadaci']}\n";
            $prompt .= "   - Minimum 2-3 detaljna pasusa\n";
            $prompt .= "   - Koristi stručan, formalni ton\n";
            $prompt .= "   - Uključi konkretne primere i procedure\n\n";
        }
        
        $prompt .= "ZAHTEVI:\n";
        $prompt .= "- Piši na srpskom jeziku\n";
        $prompt .= "- Poštuj zakone Republike Srbije\n";
        $prompt .= "- Koristi formalni, stručan ton\n";
        $prompt .= "- Uključi tabele gde je potrebno\n";
        $prompt .= "- Plan mora biti spreman za direktan eksport u PDF\n\n";
        
        $prompt .= "Generiši kompletan plan sa svim poglavljima:";

        return $prompt;
    }

    /**
     * Kreiraj prompt za poglavlje
     */
    private function buildChapterPrompt(array $poglavlje, array $data): string
    {
        $prompt = "Generiši detaljno poglavlje '{$poglavlje['naziv']}' u okviru Plana upravljanja otpadom.\n\n";
        
        $prompt .= "PODACI O FIRMI:\n";
        $prompt .= "Naziv firme: {$data['naziv_firme']}\n";
        $prompt .= "PIB: {$data['pib']}\n";
        $prompt .= "Delatnost: {$data['delatnost']}\n";
        $prompt .= "Adresa: {$data['adresa']}\n";
        $prompt .= "Vrste otpada: {$data['vrste_otpada']}\n";
        $prompt .= "Način skladištenja: {$data['nacin_skladistenja']}\n";
        $prompt .= "Operateri: {$data['operateri']}\n";
        
        if (!empty($data['broj_zaposlenih'])) {
            $prompt .= "Broj zaposlenih: {$data['broj_zaposlenih']}\n";
        }
        
        if (!empty($data['povrsina_objekta'])) {
            $prompt .= "Površina objekta: {$data['povrsina_objekta']} m²\n";
        }
        
        if (!empty($data['napomene'])) {
            $prompt .= "Napomene: {$data['napomene']}\n";
        }

        $prompt .= "\nZADATCI ZA POGLAVLJE:\n";
        $prompt .= $poglavlje['zadaci'] . "\n\n";
        
        $prompt .= "ZAHTEVI:\n";
        $prompt .= "- Minimum 2-3 detaljna pasusa\n";
        $prompt .= "- Koristi stručan, formalni ton\n";
        $prompt .= "- Piši na srpskom jeziku\n";
        $prompt .= "- Poštuj zakone Republike Srbije\n";
        $prompt .= "- Uključi konkretne primere i procedure\n";
        $prompt .= "- Ako je potrebno, dodaj tabele ili liste\n\n";
        
        $prompt .= "Generiši sadržaj poglavlja:";

        return $prompt;
    }

    /**
     * Formatiraj poglavlje za finalni plan
     */
    private function formatChapter(array $poglavlje, string $sadrzaj, int $broj): string
    {
        $formatted = "\n\n" . str_repeat("=", 80) . "\n";
        $formatted .= "{$broj}. {$poglavlje['naziv']}\n";
        $formatted .= str_repeat("=", 80) . "\n\n";
        $formatted .= $sadrzaj . "\n";
        
        return $formatted;
    }

    /**
     * Definiši sva poglavlja plana
     */
    private function getPoglavlja(): array
    {
        return [
            [
                'naziv' => 'Uvod i pravni osnov',
                'zadaci' => 'Uključi pravni osnov za izradu plana, ciljeve i zadatke plana, odgovornosti i kompetencije. Obrazloži zašto je potreban plan upravljanja otpadom.'
            ],
            [
                'naziv' => 'Opis firme i lokacije',
                'zadaci' => 'Detaljno opiši firmu, njen PIB, delatnost, broj zaposlenih, organizacionu strukturu, lokaciju postrojenja i prostorni raspored.'
            ],
            [
                'naziv' => 'Postojeći sistem upravljanja otpadom',
                'zadaci' => 'Analiziraj trenutno stanje upravljanja otpadom u firmi, identifikuj probleme i nedostaci, predloži potrebne izmene i poboljšanja.'
            ],
            [
                'naziv' => 'Vrste otpada koje nastaju',
                'zadaci' => 'Napravi detaljnu listu svih vrsta otpada sa EWC kodovima, opisom i količinama. Uključi karakteristike i opasnosti otpada, mesto nastajanja.'
            ],
            [
                'naziv' => 'Način razdvajanja i skladištenja otpada',
                'zadaci' => 'Opiši metode razdvajanja otpada na mestu nastajanja, skladištenje i privremeno čuvanje, označavanje i etiketiranje kontejnera, bezbednosne mere.'
            ],
            [
                'naziv' => 'Predaja otpada i ugovoreni operateri',
                'zadaci' => 'Lista ugovorenih operatera za svaki tip otpada, frekvencija i način predaje otpada, ugovorni odnosi i obaveze. Uključi tabele sa podacima o operaterima.'
            ],
            [
                'naziv' => 'Evidencije i izveštavanje',
                'zadaci' => 'Opiši evidenciju otpada (Obrazac DNE), godišnji izveštaj (Obrazac GDE), odgovorne za vođenje evidencije, arhiviranje dokumenata.'
            ],
            [
                'naziv' => 'Mogućnosti za smanjenje količine otpada',
                'zadaci' => 'Predloži strategiju smanjenja količine otpada, mogućnosti ponovne upotrebe, reciklažu i preradu, ekonomske aspekte.'
            ],
            [
                'naziv' => 'Procena rizika po životnu sredinu',
                'zadaci' => 'Identifikuj rizike po životnu sredinu, mere zaštite i prevencije, plan reagovanja u slučaju nesreće, monitoring i kontrola.'
            ],
            [
                'naziv' => 'Zaključak i preporuke',
                'zadaci' => 'Rezime implementiranih mera, preporuke za unapređenje, plan kontinuiranog poboljšanja sistema upravljanja otpadom.'
            ]
        ];
    }
}

