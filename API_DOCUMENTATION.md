# EconsaltAI API Documentation

## Waste Management Plan Generation API

### Endpoint

```
POST /generate-plan
```

### Description

Generiše detaljan plan upravljanja otpadom za firmu koristeći OpenAI GPT-4o-mini model, u skladu sa zakonima Republike Srbije.

### Authentication

Endpoint zahteva autentifikaciju (middleware: auth).

### Request Parameters

| Parameter            | Type   | Required | Description                               |
| -------------------- | ------ | -------- | ----------------------------------------- |
| `naziv_firme`        | string | Yes      | Naziv firme (max 255 karaktera)           |
| `pib`                | string | Yes      | PIB firme (max 20 karaktera)              |
| `delatnost`          | string | Yes      | Opis delatnosti firme (max 255 karaktera) |
| `lokacija`           | string | Yes      | Lokacija postrojenja (max 255 karaktera)  |
| `vrste_otpada`       | string | Yes      | Opis vrsta otpada koje nastaju            |
| `nacin_zbrinjavanja` | string | Yes      | Način na koji se otpad trenutno zbrinjava |

### Request Example

```json
{
    "naziv_firme": "ABC DOO Beograd",
    "pib": "123456789",
    "delatnost": "Proizvodnja plastičnih proizvoda",
    "lokacija": "Industrijska zona 15, Beograd",
    "vrste_otpada": "Plastični otpad, metalni otpad, papir, elektronika",
    "nacin_zbrinjavanja": "Imamo ugovor sa operaterom za zbrinjavanje otpada"
}
```

### Response Format

#### Success Response (200 OK)

```json
{
    "success": true,
    "message": "Plan upravljanja otpadom je uspešno generisan",
    "data": {
        "plan": "Detaljan tekst plana upravljanja otpadom...",
        "firma": {
            "naziv": "ABC DOO Beograd",
            "pib": "123456789",
            "delatnost": "Proizvodnja plastičnih proizvoda",
            "lokacija": "Industrijska zona 15, Beograd"
        },
        "generated_at": "2024-01-15 14:30:25"
    }
}
```

#### Validation Error Response (422 Unprocessable Entity)

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "naziv_firme": ["The naziv firme field is required."],
        "pib": ["The pib field is required."]
    }
}
```

#### Server Error Response (500 Internal Server Error)

```json
{
    "success": false,
    "message": "Greška prilikom generisanja plana: OpenAI API error"
}
```

### Plan Content Structure

Generisani plan sadrži sledeće sekcije u skladu sa zakonima Republike Srbije:

1. **Uvod i opis firme** - delatnost, broj zaposlenih, lokacija, glavne aktivnosti
2. **Vrste otpada** - sa EWC kodovima i opisom
3. **Način razdvajanja, skladištenja i označavanja otpada**
4. **Ugovorene operatere i način predaje otpada**
5. **Mere za smanjenje količine otpada** - ponovna upotreba i reciklaža
6. **Evidencija i godišnje izveštavanje** - Obrazac DNE i GDE
7. **Procena rizika po životnu sredinu** - mere zaštite
8. **Zaključak i preporuke** - unapređenje sistema upravljanja otpadom

### Legal Compliance

Plan je generisan u skladu sa:

-   Zakonom o upravljanju otpadom ("Službeni glasnik RS", br. 36/2009, 88/2010, 14/2016, 95/2018, 35/2021)
-   Pravilnikom o obrascima evidencije i godišnjem izveštaju o upravljanju otpadom ("Službeni glasnik RS", br. 93/2019)
-   Pravilnikom o upravljanju otpadom koji nastaje u industriji ("Službeni glasnik RS", br. 25/2019)
-   Uredbom o kategorijama otpada, testiranju i klasifikaciji otpada ("Službeni glasnik RS", br. 56/2010, 93/2019, 25/2020)
-   Zakonom o zaštiti životne sredine
-   Relevantnim delovima EU Direktive 2008/98/EC o otpadu

### Usage Example (cURL)

```bash
curl -X POST http://localhost:8000/generate-plan \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "naziv_firme": "Test DOO",
    "pib": "987654321",
    "delatnost": "Proizvodnja",
    "lokacija": "Beograd",
    "vrste_otpada": "Papir, plastika",
    "nacin_zbrinjavanja": "Operater"
  }'
```

### Usage Example (JavaScript)

```javascript
const response = await fetch("/generate-plan", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
    },
    body: JSON.stringify({
        naziv_firme: "ABC DOO",
        pib: "123456789",
        delatnost: "Proizvodnja",
        lokacija: "Beograd",
        vrste_otpada: "Papir, plastika",
        nacin_zbrinjavanja: "Operater",
    }),
});

const data = await response.json();
console.log(data);
```

### Rate Limiting

Endpoint je zaštićen standardnim Laravel middleware-om za autentifikaciju.

### Error Handling

-   **422**: Validation errors - proverite da li su svi obavezni parametri poslati
-   **500**: Server errors - proverite da li je OpenAI API ključ konfigurisan
-   **401**: Authentication required - potrebna je prijava u sistem

### Testing

Za testiranje API-ja možete koristiti test stranicu na `/api-test` endpoint-u.

