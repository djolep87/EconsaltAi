<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('AI Generator - Plan Upravljanja Otpadom') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Generiši Plan Upravljanja Otpadom
                        </h2>
                        <p class="text-lg text-gray-600">
                            Unesite podatke o vašoj firmi i automatski generišite kompletan plan upravljanja otpadom
                        </p>
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Planovi će biti automatski sačuvani u vašem dashboard-u
                            </p>
                        </div>
                    </div>

                    <!-- Loading Overlay -->
                    <div id="loadingOverlay" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3 text-center">
                                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                                    <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mt-4">Generiše se plan...</h3>
                                <div class="mt-2 px-7 py-3">
                                    <p class="text-sm text-gray-500" id="loadingText">
                                        Generiše se kompletan plan upravljanja otpadom. Molimo sačekajte...
                                    </p>
                                    <div class="mt-3">
                                        <div class="bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full animate-pulse" style="width: 100%"></div>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1" id="progressText">
                                            Ovo može potrajati do 2 minuta...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Plan je uspešno generisan!</p>
                                <p class="text-sm">Možete preuzeti PDF dokument.</p>
                                <p class="text-sm text-blue-600 mt-1">Plan je takođe sačuvan u vašem dashboard-u.</p>
                                <div class="mt-3">
                                    <a id="downloadLink" href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Preuzmi PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM11 4v4H8v2h3v4h2v-4h3V8h-3V4h-2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Došlo je do greške!</p>
                                <p class="text-sm" id="errorText">Molimo pokušajte ponovo.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="planForm" class="space-y-6" method="POST" action="{{ route('plan.generate') }}">
                        @csrf
                        
                        <!-- Company Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Osnovni podaci o firmi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="naziv_firme" class="block text-sm font-medium text-gray-700 mb-2">
                                        Naziv firme *
                                    </label>
                                    <input type="text" id="naziv_firme" name="naziv_firme" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label for="pib" class="block text-sm font-medium text-gray-700 mb-2">
                                        PIB *
                                    </label>
                                    <input type="text" id="pib" name="pib" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="delatnost" class="block text-sm font-medium text-gray-700 mb-2">
                                        Delatnost firme *
                                    </label>
                                    <input type="text" id="delatnost" name="delatnost" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="adresa" class="block text-sm font-medium text-gray-700 mb-2">
                                        Adresa firme *
                                    </label>
                                    <textarea id="adresa" name="adresa" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                
                                <div>
                                    <label for="broj_zaposlenih" class="block text-sm font-medium text-gray-700 mb-2">
                                        Broj zaposlenih
                                    </label>
                                    <input type="number" id="broj_zaposlenih" name="broj_zaposlenih" min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                
                                <div>
                                    <label for="povrsina_objekta" class="block text-sm font-medium text-gray-700 mb-2">
                                        Površina objekta (m²)
                                    </label>
                                    <input type="number" id="povrsina_objekta" name="povrsina_objekta" min="0" step="0.01"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Waste Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informacije o otpadu</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="vrste_otpada" class="block text-sm font-medium text-gray-700 mb-2">
                                        Vrste otpada koje nastaju *
                                    </label>
                                    <textarea id="vrste_otpada" name="vrste_otpada" rows="4" required
                                              placeholder="Opišite koje vrste otpada nastaju u vašoj firmi (npr. papir, plastika, metal, staklo, elektronski otpad, opasan otpad, itd.)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                
                                <div>
                                    <label for="nacin_skladistenja" class="block text-sm font-medium text-gray-700 mb-2">
                                        Način skladištenja otpada *
                                    </label>
                                    <textarea id="nacin_skladistenja" name="nacin_skladistenja" rows="3" required
                                              placeholder="Opišite kako trenutno skladištite otpad (kontejneri, skladišta, posebne prostorije, itd.)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                
                                <div>
                                    <label for="operateri" class="block text-sm font-medium text-gray-700 mb-2">
                                        Operateri za upravljanje otpadom *
                                    </label>
                                    <textarea id="operateri" name="operateri" rows="3" required
                                              placeholder="Navedite koje operatere koristite za odvoženje i zbrinjavanje otpada (naziv firme, adresa, tip otpada)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                                
                                <div>
                                    <label for="napomene" class="block text-sm font-medium text-gray-700 mb-2">
                                        Dodatne napomene
                                    </label>
                                    <textarea id="napomene" name="napomene" rows="3"
                                              placeholder="Dodatne informacije o vašoj firmi, specifičnim potrebama za upravljanje otpadom, itd."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" id="generateButton"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 ease-in-out transform hover:scale-105">
                                <span id="buttonText">Generiši Plan</span>
                                <svg id="buttonSpinner" class="hidden animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Plan generator form loaded');
            
            const form = document.getElementById('planForm');
            if (!form) {
                console.error('Form not found!');
                return;
            }
            
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                console.log('Form submitted!');
                
                const generateButton = document.getElementById('generateButton');
                const buttonText = document.getElementById('buttonText');
                const buttonSpinner = document.getElementById('buttonSpinner');
                const loadingOverlay = document.getElementById('loadingOverlay');
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');
                
                // Hide previous messages
                successMessage.classList.add('hidden');
                errorMessage.classList.add('hidden');
                
                // Show loading state
                generateButton.disabled = true;
                buttonText.textContent = 'Generiše se...';
                buttonSpinner.classList.remove('hidden');
                loadingOverlay.classList.remove('hidden');
                
                try {
                    console.log('Sending request...');
                    
                    const formData = new FormData(form);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    // Kreiraj AbortController za timeout
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 300000); // 5 minuta timeout
                    
                    const response = await fetch('{{ route("plan.generate") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    console.log('Response status:', response.status);
                    
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    
                    const data = await response.json();
                    console.log('Response data:', data);
                    
                    if (data.success) {
                        // Show success message
                        successMessage.classList.remove('hidden');
                        document.getElementById('downloadLink').href = data.download_url;
                        
                        // Add dashboard link if user is logged in and plan was saved
                        if (data.dashboard_url) {
                            const dashboardLink = document.createElement('a');
                            dashboardLink.href = data.dashboard_url;
                            dashboardLink.className = 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2';
                            dashboardLink.textContent = 'Vidi u Dashboard-u';
                            document.getElementById('downloadLink').parentNode.appendChild(dashboardLink);
                        }
                        
                        // Scroll to success message
                        successMessage.scrollIntoView({ behavior: 'smooth' });
                    } else {
                        // Show error message
                        errorMessage.classList.remove('hidden');
                        document.getElementById('errorText').textContent = data.message || 'Došlo je do greške. Molimo pokušajte ponovo.';
                    }
                    
                } catch (error) {
                    console.error('Error details:', error);
                    
                    errorMessage.classList.remove('hidden');
                    
                    let errorText = 'Došlo je do greške: ' + error.message;
                    
                    if (error.name === 'AbortError') {
                        errorText = 'Generisanje plana je prekoračilo vreme čekanja. Molimo pokušajte ponovo.';
                    } else if (error.message.includes('timeout')) {
                        errorText = 'Generisanje plana je prekoračilo vreme čekanja. Molimo pokušajte ponovo.';
                    } else if (error.message.includes('rate_limit') || error.message.includes('quota')) {
                        errorText = 'AI servis je trenutno opterećen. Molimo pokušajte ponovo za nekoliko minuta.';
                    } else if (error.message.includes('connection') || error.message.includes('network')) {
                        errorText = 'Problem sa internet konekcijom. Molimo proverite konekciju i pokušajte ponovo.';
                    }
                    
                    document.getElementById('errorText').textContent = errorText;
                } finally {
                    // Reset button state
                    generateButton.disabled = false;
                    buttonText.textContent = 'Generiši Plan';
                    buttonSpinner.classList.add('hidden');
                    loadingOverlay.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
