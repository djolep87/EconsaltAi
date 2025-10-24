<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test API Endpoint - EconsaltAI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Test API Endpoint - Generisanje Planova</h1>
            
            <form id="planForm" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="naziv_firme" class="block text-sm font-medium text-gray-700 mb-2">
                            Naziv firme *
                        </label>
                        <input type="text" id="naziv_firme" name="naziv_firme" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Naziv vaše firme">
                    </div>
                    
                    <div>
                        <label for="pib" class="block text-sm font-medium text-gray-700 mb-2">
                            PIB *
                        </label>
                        <input type="text" id="pib" name="pib" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="PIB firme">
                    </div>
                </div>
                
                <div>
                    <label for="delatnost" class="block text-sm font-medium text-gray-700 mb-2">
                        Delatnost *
                    </label>
                    <input type="text" id="delatnost" name="delatnost" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Opis delatnosti firme">
                </div>
                
                <div>
                    <label for="lokacija" class="block text-sm font-medium text-gray-700 mb-2">
                        Lokacija postrojenja *
                    </label>
                    <input type="text" id="lokacija" name="lokacija" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Adresa postrojenja">
                </div>
                
                <div>
                    <label for="vrste_otpada" class="block text-sm font-medium text-gray-700 mb-2">
                        Vrste otpada *
                    </label>
                    <textarea id="vrste_otpada" name="vrste_otpada" required rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Opisite vrste otpada koje nastaju u vašoj firmi (papir, plastika, metal, staklo, elektronika, opasan otpad, itd.)"></textarea>
                </div>
                
                <div>
                    <label for="nacin_zbrinjavanja" class="block text-sm font-medium text-gray-700 mb-2">
                        Način zbrinjavanja otpada *
                    </label>
                    <textarea id="nacin_zbrinjavanja" name="nacin_zbrinjavanja" required rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Opisite kako trenutno zbrinjavate otpad (imam ugovor sa operaterom, zbrinjavam sam, itd.)"></textarea>
                </div>
                
                <button type="submit" id="generateBtn"
                        class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium">
                    Generiši Plan
                </button>
            </form>
            
            <!-- Loading indicator -->
            <div id="loading" class="hidden mt-6">
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex items-center">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600 mr-3"></div>
                        <span class="text-blue-700">Generiše se plan upravljanja otpadom...</span>
                    </div>
                </div>
            </div>
            
            <!-- Results -->
            <div id="results" class="hidden mt-6">
                <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-4">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">Plan uspešno generisan!</h3>
                    <div id="firmaInfo" class="text-sm text-green-700 mb-3"></div>
                    <div id="generatedAt" class="text-xs text-green-600"></div>
                </div>
                
                <div class="bg-white border border-gray-200 rounded-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Generisani Plan:</h3>
                    <div id="planContent" class="prose max-w-none text-gray-700 whitespace-pre-wrap"></div>
                </div>
            </div>
            
            <!-- Error display -->
            <div id="error" class="hidden mt-6">
                <div class="bg-red-50 border border-red-200 rounded-md p-4">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">Greška!</h3>
                    <div id="errorMessage" class="text-red-700"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('planForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const generateBtn = document.getElementById('generateBtn');
            const loading = document.getElementById('loading');
            const results = document.getElementById('results');
            const error = document.getElementById('error');
            
            // Reset UI
            generateBtn.disabled = true;
            generateBtn.textContent = 'Generiše se...';
            loading.classList.remove('hidden');
            results.classList.add('hidden');
            error.classList.add('hidden');
            
            try {
                const response = await fetch('/generate-plan', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        naziv_firme: formData.get('naziv_firme'),
                        pib: formData.get('pib'),
                        delatnost: formData.get('delatnost'),
                        lokacija: formData.get('lokacija'),
                        vrste_otpada: formData.get('vrste_otpada'),
                        nacin_zbrinjavanja: formData.get('nacin_zbrinjavanja')
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Display success
                    document.getElementById('firmaInfo').innerHTML = `
                        <strong>${data.data.firma.naziv}</strong><br>
                        PIB: ${data.data.firma.pib}<br>
                        Delatnost: ${data.data.firma.delatnost}<br>
                        Lokacija: ${data.data.firma.lokacija}
                    `;
                    document.getElementById('generatedAt').textContent = 
                        `Generisano: ${data.data.generated_at}`;
                    document.getElementById('planContent').textContent = data.data.plan;
                    
                    results.classList.remove('hidden');
                } else {
                    // Display error
                    document.getElementById('errorMessage').textContent = data.message;
                    if (data.errors) {
                        document.getElementById('errorMessage').innerHTML += '<br><br>Detalji:<br>' + 
                            Object.values(data.errors).flat().join('<br>');
                    }
                    error.classList.remove('hidden');
                }
                
            } catch (err) {
                console.error('Error:', err);
                document.getElementById('errorMessage').textContent = 
                    'Greška u komunikaciji sa serverom: ' + err.message;
                error.classList.remove('hidden');
            } finally {
                generateBtn.disabled = false;
                generateBtn.textContent = 'Generiši Plan';
                loading.classList.add('hidden');
            }
        });
    </script>
</body>
</html>

