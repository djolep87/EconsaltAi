# AI Plan Generator - Dokumentacija

## Pregled sistema

AI Plan Generator je kompletan backend sistem koji automatski generiše planove upravljanja otpadom koristeći OpenAI API. Sistem je dizajniran da generiše detaljne, profesionalne planove u skladu sa zakonima Republike Srbije.

## Funkcionalnosti

### 1. Automatsko generisanje plana po poglavljima

-   **10 poglavlja** se generiše sekvencijalno
-   Svako poglavlje se šalje kao poseban zahtev OpenAI API-ju
-   Optimizovano za brzinu i pouzdanost

### 2. Struktura plana

1. Uvod i pravni osnov
2. Opis firme i lokacije
3. Postojeći sistem upravljanja otpadom
4. Vrste otpada koje nastaju
5. Način razdvajanja i skladištenja otpada
6. Predaja otpada i ugovoreni operateri
7. Evidencije i izveštavanje
8. Mogućnosti za smanjenje količine otpada
9. Procena rizika po životnu sredinu
10. Zaključak i preporuke

### 3. PDF generisanje

-   Automatsko kreiranje PDF-a nakon generisanja plana
-   Profesionalni template sa stilizovanim sadržajem
-   Čuvanje u `storage/app/public/plans/`
-   Direktno preuzimanje

## Tehnička implementacija

### Kontroleri

-   **`PlanGeneratorController`** - glavni kontroler za plan generator
-   **`PlanGeneratorService`** - servis za upravljanje generisanjem
-   **`OpenAIService`** - proširen sa `generateChapter()` metodom

### Rute

```php
Route::get('/plan-generator', [PlanGeneratorController::class, 'showForm']);
Route::post('/generate-plan', [PlanGeneratorController::class, 'generatePlan']);
Route::get('/plan/download/{filename}', [PlanGeneratorController::class, 'downloadPlan']);
```

### Frontend

-   **Responsive forma** sa Tailwind CSS
-   **AJAX funkcionalnost** za generisanje bez refresh-a
-   **Loading indikatori** i error handling
-   **Real-time feedback** tokom generisanja

## Korišćenje

### 1. Pristup generatoru

-   Direktno: `/plan-generator`
-   Preko navigacije: "AI Generator" link
-   Sa welcome stranice: "AI Generator" dugme

### 2. Unos podataka

Korisnik unosi:

-   **Osnovni podaci**: naziv firme, PIB, delatnost, adresa
-   **Dodatni podaci**: broj zaposlenih, površina objekta
-   **Informacije o otpadu**: vrste otpada, način skladištenja, operateri
-   **Napomene**: dodatne informacije

### 3. Proces generisanja

1. Validacija podataka
2. Generisanje 10 poglavlja sekvencijalno
3. Spajanje sadržaja u finalni plan
4. Generisanje PDF-a
5. Čuvanje i prikaz linka za preuzimanje

## Error handling

### OpenAI API greške

-   **Timeout**: "AI servis je prekoračio vreme čekanja"
-   **Rate limit**: "AI servis je trenutno opterećen"
-   **Connection**: "Problem sa internet konekcijom"
-   **General**: "Neočekivana greška prilikom generisanja plana"

### PDF generisanje greške

-   Automatsko kreiranje direktorijuma
-   Error handling za čuvanje fajlova
-   Validacija postojanja fajlova pri preuzimanju

## Konfiguracija

### Potrebni paketi

-   `barryvdh/laravel-dompdf` - za PDF generisanje
-   `openai-php/laravel` - za OpenAI API
-   `laravel/cashier` - za pretplate (opciono)

### Environment varijable

```env
OPENAI_API_KEY=your_openai_api_key
```

### Storage link

```bash
php artisan storage:link
```

## Napredne funkcionalnosti

### 1. Optimizacija performansi

-   Sekvencijalno generisanje poglavlja
-   Pauza između zahteva (0.5s)
-   Optimizovani tokeni po poglavlju (2000)

### 2. Logging

-   Detaljno logovanje svih operacija
-   Error tracking sa kontekstom
-   Performance monitoring

### 3. Proširivost

-   Lako dodavanje novih poglavlja
-   Konfigurabilni promptovi
-   Modularna arhitektura

## Sigurnost

### CSRF zaštita

-   Svi POST zahtevi zaštićeni CSRF tokenom
-   Validacija na backend-u

### File security

-   Validacija ekstenzija fajlova
-   Bezbedno čuvanje u storage
-   Kontrola pristupa preuzimanju

## Monitoring i održavanje

### Log fajlovi

-   `storage/logs/laravel.log` - svi logovi
-   Filter po "Plan generation" za relevantne logove

### Čišćenje starih fajlova

```bash
# Uklanjanje starih PDF fajlova (opciono)
find storage/app/public/plans -name "*.pdf" -mtime +30 -delete
```

## Troubleshooting

### Česti problemi

1. **"OpenAI API ključ nije konfigurisan"**

    - Proverite `OPENAI_API_KEY` u `.env` fajlu

2. **"Greška pri generisanju PDF-a"**

    - Proverite da li je `storage/app/public` writable
    - Pokrenite `php artisan storage:link`

3. **"Fajl nije pronađen" pri preuzimanju**
    - Proverite da li je PDF uspešno generisan
    - Proverite storage link

### Debug mode

```env
LOG_LEVEL=debug
```

## Buduća poboljšanja

1. **Asinhrono generisanje** - koristeći Laravel Queues
2. **Email notifikacije** - kada je plan gotov
3. **Template customizacija** - različiti PDF templatei
4. **Batch processing** - generisanje više planova odjednom
5. **Analytics** - praćenje korišćenja i performansi

## Podrška

Za tehničku podršku ili pitanja o implementaciji, kontaktirajte development tim.

