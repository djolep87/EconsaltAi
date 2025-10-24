<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Izmena plana upravljanja otpadom - ' . $plan->company_name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">
                            Izmeni Plan Upravljanja Otpadom
                        </h2>
                        <p class="text-lg text-gray-600">
                            Ažurirajte podatke o vašoj firmi i planu upravljanja otpadom
                        </p>
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Izmene će biti automatski sačuvane u vašem dashboard-u
                            </p>
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold">Plan je uspešno ažuriran!</p>
                                    <p class="text-sm">Možete nastaviti sa pregledom ili generisanjem AI plana.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM11 4v4H8v2h3v4h2v-4h3V8h-3V4h-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold">Došlo je do greške!</p>
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('plans.update', $plan) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Company Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Osnovni podaci o firmi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="naziv_firme" class="block text-sm font-medium text-gray-700 mb-2">
                                        Naziv firme *
                                    </label>
                                    <input type="text" id="naziv_firme" name="naziv_firme" value="{{ old('naziv_firme', $plan->naziv_firme) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('naziv_firme')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="pib" class="block text-sm font-medium text-gray-700 mb-2">
                                        PIB *
                                    </label>
                                    <input type="text" id="pib" name="pib" value="{{ old('pib', $plan->pib) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('pib')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="delatnost" class="block text-sm font-medium text-gray-700 mb-2">
                                        Delatnost firme *
                                    </label>
                                    <input type="text" id="delatnost" name="delatnost" value="{{ old('delatnost', $plan->delatnost) }}" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('delatnost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="adresa" class="block text-sm font-medium text-gray-700 mb-2">
                                        Adresa firme *
                                    </label>
                                    <textarea id="adresa" name="adresa" rows="3" required
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('adresa', $plan->adresa) }}</textarea>
                                    @error('adresa')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="broj_zaposlenih" class="block text-sm font-medium text-gray-700 mb-2">
                                        Broj zaposlenih
                                    </label>
                                    <input type="number" id="broj_zaposlenih" name="broj_zaposlenih" value="{{ old('broj_zaposlenih', $plan->broj_zaposlenih) }}" min="1"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('broj_zaposlenih')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="povrsina_objekta" class="block text-sm font-medium text-gray-700 mb-2">
                                        Površina objekta (m²)
                                    </label>
                                    <input type="number" id="povrsina_objekta" name="povrsina_objekta" value="{{ old('povrsina_objekta', $plan->povrsina_objekta) }}" min="0" step="0.01"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('povrsina_objekta')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('vrste_otpada', $plan->vrste_otpada) }}</textarea>
                                    @error('vrste_otpada')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="nacin_skladistenja" class="block text-sm font-medium text-gray-700 mb-2">
                                        Način skladištenja otpada *
                                    </label>
                                    <textarea id="nacin_skladistenja" name="nacin_skladistenja" rows="3" required
                                              placeholder="Opišite kako trenutno skladištite otpad (kontejneri, skladišta, posebne prostorije, itd.)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('nacin_skladistenja', $plan->nacin_skladistenja) }}</textarea>
                                    @error('nacin_skladistenja')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="operateri" class="block text-sm font-medium text-gray-700 mb-2">
                                        Operateri za upravljanje otpadom *
                                    </label>
                                    <textarea id="operateri" name="operateri" rows="3" required
                                              placeholder="Navedite koje operatere koristite za odvoženje i zbrinjavanje otpada (naziv firme, adresa, tip otpada)"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('operateri', $plan->operateri) }}</textarea>
                                    @error('operateri')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="napomene" class="block text-sm font-medium text-gray-700 mb-2">
                                        Dodatne napomene
                                    </label>
                                    <textarea id="napomene" name="napomene" rows="3"
                                              placeholder="Dodatne informacije o vašoj firmi, specifičnim potrebama za upravljanje otpadom, itd."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('napomene', $plan->napomene) }}</textarea>
                                    @error('napomene')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <div class="flex justify-center space-x-4">
                                <a href="{{ route('plans.show', $plan) }}" 
                                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 ease-in-out">
                                    Otkaži
                                </a>
                                <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 ease-in-out transform hover:scale-105">
                                    Sačuvaj izmene
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>