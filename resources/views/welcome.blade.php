<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EconsaltAI - AI Planovi Upravljanja Otpadom</title>
        <meta name="description" content="Generišite profesionalne planove upravljanja otpadom pomoću umetne inteligencije. Jednostavno, brzo i efikasno.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Tailwind CSS styles will be loaded via Vite */
            </style>
        @endif
    </head>
    <body class="bg-white text-gray-900">
        <!-- Navigation -->
        @include('layouts.shared-navigation')

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-green-50 to-blue-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                        AI Planovi Upravljanja
                        <span class="text-green-600">Otpadom</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-6 max-w-4xl mx-auto">
                        <strong class="text-gray-900">Prekinite sa stresom oko upravljanja otpadom!</strong> EconsaltAI je prva aplikacija u Srbiji koja koristi umetnu inteligenciju za kreiranje profesionalnih planova upravljanja otpadom. 
                        U nekoliko minuta dobijate kompletnu strategiju koja je u potpunosti usklađena sa srpskim zakonima i međunarodnim standardima.
                    </p>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 max-w-4xl mx-auto mb-8">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-red-800 mb-2">Bez EconsaltAI-a riskirate:</h3>
                                <ul class="text-sm text-red-700 space-y-1">
                                    <li>• <strong>Kazne do 2.000.000 dinara</strong> od Agencije za zaštitu životne sredine</li>
                                    <li>• <strong>Zatvaranje firme</strong> zbog neispunjavanja zakonskih obaveza</li>
                                    <li>• <strong>Gubljenje klijenata</strong> koji traže ekološki sertifikat</li>
                                    <li>• <strong>Nedostupan pristup javnim tenderima</strong> bez plana upravljanja otpadom</li>
                                    <li>• <strong>Visoke troškove konsultanata</strong> (3.000-15.000€ po planu)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold">
                                Idi na Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg text-lg font-semibold">
                                Probaj besplatno
                            </a>
                            <a href="{{ route('login') }}" class="border border-gray-300 hover:border-gray-400 text-gray-700 px-8 py-4 rounded-lg text-lg font-semibold">
                                Prijavi se
                            </a>
                        @endauth
                    </div>
                    <p class="text-sm text-gray-500 mt-4">7 dana besplatno • Bez obaveza</p>
                    
                    <!-- Statistics -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">500+</div>
                            <div class="text-sm text-gray-600">Firmi koristi uslugu</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">2,000+</div>
                            <div class="text-sm text-gray-600">Generisanih planova</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">98%</div>
                            <div class="text-sm text-gray-600">Zadovoljstinu klijenata</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-orange-600 mb-2">24/7</div>
                            <div class="text-sm text-gray-600">Dostupnost</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Problem Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Da li se prepoznajete u ovim situacijama?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Svaki dan na stotine firmi u Srbiji suočava se sa istim problemima
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-red-800">Preuzimanje posla</h3>
                        </div>
                        <p class="text-red-700 text-sm">
                            "Preuzeo sam firmu od prethodnog vlasnika koji nije imao plan upravljanja otpadom. Agencija za zaštitu životne sredine traži da predam plan u roku od 30 dana ili plaćam kaznu od 500.000 dinara. Ne znam odakle da počnem!"
                        </p>
                        <div class="mt-4 text-xs text-red-600 font-semibold">- Marko, direktor proizvodne firme</div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-orange-800">Javni tenderi</h3>
                        </div>
                        <p class="text-orange-700 text-sm">
                            "Izgubili smo tender vredan 50 miliona dinara jer nismo imali plan upravljanja otpadom. Konkurencija je imala, a mi ne. Sada moram hitno da napravim plan da ne izgubim sledeći tender."
                        </p>
                        <div class="mt-4 text-xs text-orange-600 font-semibold">- Ana, menadžer u građevinskoj firmi</div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-purple-800">Visoki troškovi</h3>
                        </div>
                        <p class="text-purple-700 text-sm">
                            "Konsultant traži 8.000€ za kreiranje plana upravljanja otpadom. To je ogroman trošak za našu firmu. Postoji li neki jeftiniji način da dobijem profesionalan plan?"
                        </p>
                        <div class="mt-4 text-xs text-purple-600 font-semibold">- Petar, vlasnik malog biznisa</div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-800">Kompleksnost procesa</h3>
                        </div>
                        <p class="text-blue-700 text-sm">
                            "Pokušavam da napravim plan upravljanja otpadom sam, ali je to previše složeno. Postoji toliko različitih tipova otpada, zakona i regulativa da se gubim u tome."
                        </p>
                        <div class="mt-4 text-xs text-blue-600 font-semibold">- Jelena, ekološki koordinator</div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800">Gubljenje klijenata</h3>
                        </div>
                        <p class="text-green-700 text-sm">
                            "Naš najveći klijent traži da imamo sertifikat o upravljanju otpadom kao deo ugovora. Bez toga gubimo ugovor vredan 200.000€ godišnje. Trebam hitno rešenje!"
                        </p>
                        <div class="mt-4 text-xs text-green-600 font-semibold">- Nikola, direktor servisne firme</div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-indigo-800">Vremenski pritisak</h3>
                        </div>
                        <p class="text-indigo-700 text-sm">
                            "Imam rok od 2 nedelje da predam plan upravljanja otpadom inspekciji. Konsultanti kažu da im treba najmanje mesec dana. Šta da radim?"
                        </p>
                        <div class="mt-4 text-xs text-indigo-600 font-semibold">- Milica, menadžer u proizvodnoj firmi</div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-8 rounded-2xl">
                        <h3 class="text-2xl font-bold mb-4">EconsaltAI rešava sve ove probleme!</h3>
                        <p class="text-lg mb-6">
                            U nekoliko minuta dobijate profesionalan plan koji je spreman za predaju inspekciji i u potpunosti usklađen sa srpskim zakonima.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="text-3xl font-bold">5 min</div>
                                <div class="text-sm opacity-90">Vreme kreiranja plana</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold">19€</div>
                                <div class="text-sm opacity-90">Umesto 3.000-15.000€</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold">100%</div>
                                <div class="text-sm opacity-90">Usklađeno sa zakonima</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Zašto izabrati EconsaltAI?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Automatizujte proces kreiranja planova upravljanja otpadom
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">AI Generisanje</h3>
                        <p class="text-gray-600">
                            Naš AI sistem koristi GPT-4 tehnologiju za kreiranje detaljnih i prilagođenih planova upravljanja otpadom.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">PDF Export</h3>
                        <p class="text-gray-600">
                            Preuzmite profesionalno formatiran PDF dokument sa kompletnim planom koji možete koristiti za komercijalne potrebe.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Brzo i Jednostavno</h3>
                        <p class="text-gray-600">
                            Unesite osnovne informacije o vašoj firmi i tipovima otpada, a mi ćemo generisati kompletan plan u nekoliko minuta.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Waste Types Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Pokrivamo sve tipove otpada
                    </h2>
                    <p class="text-xl text-gray-600">
                        Naš AI sistem je optimizovan za rad sa svim vrstama otpada prema srpskim regulativama
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Papir</h3>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Plastika</h3>
                    </div>
                    <div class="text-center">
                        <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Metal</h3>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Staklo</h3>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Elektronski</h3>
                    </div>
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900">Opasan</h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- Compliance Section -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        U skladu sa zakonima Republike Srbije
                    </h2>
                    <p class="text-xl text-gray-600">
                        Naši planovi su prilagođeni domaćim regulativama i međunarodnim standardima
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="bg-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Zakon o upravljanju otpadom</h3>
                        <p class="text-gray-600 text-sm">Usklađeno sa srpskim zakonima i regulativama</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Aktuelni standardi</h3>
                        <p class="text-gray-600 text-sm">Planovi u skladu sa najnovijim standardima</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Stručnost</h3>
                        <p class="text-gray-600 text-sm">Razvijeno sa stručnjacima za upravljanje otpadom</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-orange-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Kvalitet</h3>
                        <p class="text-gray-600 text-sm">Profesionalni dokumenti spremni za korišćenje</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Prednosti AI tehnologije
                    </h2>
                    <p class="text-xl text-gray-600">
                        Zašto je AI bolji od tradicionalnih metoda kreiranja planova
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div>
                        <div class="flex items-start mb-6">
                            <div class="bg-green-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Brže od čoveka</h3>
                                <p class="text-gray-600">Generisanje kompletnog plana za nekoliko minuta umesto dana ili nedelja rada.</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-6">
                            <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Uvek tačno</h3>
                                <p class="text-gray-600">AI ne pravi ljudske greške i uvek prati najnovije standarde i regulative.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prilagođeno</h3>
                                <p class="text-gray-600">Svaki plan je jedinstven i prilagođen specifičnim potrebama vaše firme.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-start mb-6">
                            <div class="bg-orange-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Ekonomski</h3>
                                <p class="text-gray-600">Znatno jeftinije od angažovanja konsultanata koji rade ručno.</p>
                            </div>
                        </div>
                        <div class="flex items-start mb-6">
                            <div class="bg-red-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Bezbedno</h3>
                                <p class="text-gray-600">Vaši podaci su zaštićeni i privatni - nema deljenja sa trećim stranama.</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Dostupno 24/7</h3>
                                <p class="text-gray-600">Generišite planove kada god vam treba, bez čekanja na termine.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Business Impact Section -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Kako EconsaltAI menja vaše poslovanje
                    </h2>
                    <p class="text-xl text-gray-600">
                        Pre i posle korišćenja EconsaltAI-a - vidite razliku
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                    <!-- Before -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-red-200">
                        <div class="flex items-center mb-6">
                            <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-800">PRE - Bez EconsaltAI-a</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Stres i neizvesnost</strong> - Ne znate da li ćete proći inspekciju</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Visoki troškovi</strong> - 3.000-15.000€ za konsultante</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Dugotrajno čekanje</strong> - 2-8 nedelja za završetak</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Rizik od kazni</strong> - Do 2.000.000 dinara</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Gubljenje prilika</strong> - Nedostupan pristup tenderima</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Gubljenje klijenata</strong> - Koji traže ekološki sertifikat</span>
                            </li>
                        </ul>
                    </div>

                    <!-- After -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-green-200">
                        <div class="flex items-center mb-6">
                            <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-green-800">POSLE - Sa EconsaltAI-om</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Mir i sigurnost</strong> - Znate da ste u skladu sa zakonima</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Minimalni troškovi</strong> - Samo 19€ mesečno</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Brzina</strong> - Plan za 5 minuta</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Bezbednost</strong> - Nema rizika od kazni</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Nove prilike</strong> - Pristup svim tenderima</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700"><strong>Zadržavanje klijenata</strong> - Imate sve potrebne sertifikate</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- ROI Calculator -->
                <div class="bg-gradient-to-r from-green-600 to-blue-600 text-white p-8 rounded-2xl">
                    <h3 class="text-2xl font-bold mb-6 text-center">Kalkulator uštede</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">15.000€</div>
                            <div class="text-sm opacity-90">Ušteda u odnosu na konsultante</div>
                            <div class="text-xs opacity-75 mt-1">(prosečna cena konsultanta)</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">2.000.000 din</div>
                            <div class="text-sm opacity-90">Izbegnuta kazna</div>
                            <div class="text-xs opacity-75 mt-1">(maksimalna kazna)</div>
                        </div>
                        <div class="text-center">
                            <div class="text-4xl font-bold mb-2">100%</div>
                            <div class="text-sm opacity-90">Sigurnost prolaženja inspekcije</div>
                            <div class="text-xs opacity-75 mt-1">(usklađeno sa zakonima)</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How it Works Section -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Kako funkcioniše?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Samo 3 jednostavna koraka do profesionalnog plana
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-6 text-xl font-bold">
                            1
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Unesite podatke</h3>
                        <p class="text-gray-600">
                            Registrujte se i unesite informacije o vašoj firmi, tipove otpada koji proizvodite i procenjene količine.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-6 text-xl font-bold">
                            2
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">AI Generiše plan</h3>
                        <p class="text-gray-600">
                            Naš AI sistem analizira vaše podatke i kreira detaljan, profesionalni plan upravljanja otpadom.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="bg-green-600 text-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-6 text-xl font-bold">
                            3
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Preuzmite PDF</h3>
                        <p class="text-gray-600">
                            Preuzmite kompletan plan u PDF formatu i koristite ga za svoje komercijalne potrebe.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Use Cases Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Za koga je EconsaltAI neophodan?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Svaki tip firme može koristiti EconsaltAI za upravljanje otpadom
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-blue-800">Proizvodne firme</h3>
                        </div>
                        <p class="text-blue-700 text-sm mb-4">
                            <strong>Obavezne su</strong> da imaju plan upravljanja otpadom. Bez njega ne mogu da dobiju dozvole za rad, izgubiće klijente i riskiraju zatvaranje.
                        </p>
                        <ul class="text-xs text-blue-600 space-y-1">
                            <li>• Automobilska industrija</li>
                            <li>• Prehrambena industrija</li>
                            <li>• Hemijska industrija</li>
                            <li>• Tekstilna industrija</li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-green-800">Građevinske firme</h3>
                        </div>
                        <p class="text-green-700 text-sm mb-4">
                            <strong>Ne mogu da učestvuju u tenderima</strong> bez plana upravljanja otpadom. To znači gubljenje milionskih ugovora i propuštanje velikih projekata.
                        </p>
                        <ul class="text-xs text-green-600 space-y-1">
                            <li>• Javni tenderi (obavezno)</li>
                            <li>• Privatni projekti</li>
                            <li>• Renoviranje zgrada</li>
                            <li>• Infrastrukturni projekti</li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-purple-800">Servisne firme</h3>
                        </div>
                        <p class="text-purple-700 text-sm mb-4">
                            <strong>Gube klijente</strong> koji traže ekološki sertifikat. Veliki klijenti sve češće zahtevaju dokaz o odgovornom upravljanju otpadom.
                        </p>
                        <ul class="text-xs text-purple-600 space-y-1">
                            <li>• IT servisi</li>
                            <li>• Marketing agencije</li>
                            <li>• Konsultantske firme</li>
                            <li>• Uslužne delatnosti</li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21v-4a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-orange-800">Trgovinske firme</h3>
                        </div>
                        <p class="text-orange-700 text-sm mb-4">
                            <strong>Obavezne su</strong> da imaju plan za pakovanje i otpad. Bez njega ne mogu da dobiju dozvole za rad i rizikuju kazne.
                        </p>
                        <ul class="text-xs text-orange-600 space-y-1">
                            <li>• Maloprodaja</li>
                            <li>• Velikoprodaja</li>
                            <li>• Online trgovina</li>
                            <li>• Specijalizovana trgovina</li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-red-800">Zdravstvene ustanove</h3>
                        </div>
                        <p class="text-red-700 text-sm mb-4">
                            <strong>Izvrsno regulisane</strong> i obavezne su da imaju detaljne planove upravljanja medicinskim otpadom. Bez njega gube licencu.
                        </p>
                        <ul class="text-xs text-red-600 space-y-1">
                            <li>• Bolnice</li>
                            <li>• Ambulante</li>
                            <li>• Stomatološke ordinacije</li>
                            <li>• Veterinarske stanice</li>
                        </ul>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-indigo-800">Obrazovne ustanove</h3>
                        </div>
                        <p class="text-indigo-700 text-sm mb-4">
                            <strong>Obavezne su</strong> da imaju plan upravljanja otpadom kao deo ekološkog obrazovanja i za dobijanje akreditacije.
                        </p>
                        <ul class="text-xs text-indigo-600 space-y-1">
                            <li>• Osnovne škole</li>
                            <li>• Srednje škole</li>
                            <li>• Fakulteti</li>
                            <li>• Obrazovni centri</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <div class="bg-gradient-to-r from-red-600 to-orange-600 text-white p-8 rounded-2xl">
                        <h3 class="text-2xl font-bold mb-4">Bez plana upravljanja otpadom ne možete:</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                            <div>
                                <div class="text-3xl font-bold mb-2">❌</div>
                                <div class="text-sm">Dobiti dozvolu za rad</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold mb-2">❌</div>
                                <div class="text-sm">Učestvovati u tenderima</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold mb-2">❌</div>
                                <div class="text-sm">Zadržati velike klijente</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold mb-2">❌</div>
                                <div class="text-sm">Izbeći kazne</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Šta kažu naši korisnici
                    </h2>
                    <p class="text-xl text-gray-600">
                        Preko 500+ firmi koristi EconsaltAI za upravljanje otpadom
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">
                            "EconsaltAI je revolucionisao naš pristup upravljanju otpadom. Uštedeli smo nedelje rada i dobili profesionalne planove u rekordnom vremenu."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">MJ</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Marko Jovanović</p>
                                <p class="text-sm text-gray-600">CEO, Ekologika d.o.o.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">
                            "Planovi su detaljni i u potpunosti usklađeni sa srpskim zakonima. Uštedeli smo hiljade evra na konsultantima."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">AN</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Ana Nikolić</p>
                                <p class="text-sm text-gray-600">Menedžer, Recykla Srbija</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-6">
                            "Odlična platforma koja nam omogućava da brzo i efikasno kreiramo planove za sve naše klijente. Korisnički interfejs je intuitivan."
                        </p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">DP</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Dr. Petar Petrović</p>
                                <p class="text-sm text-gray-600">Konsultant, GreenTech Solutions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Jednostavne cene
                    </h2>
                    <p class="text-xl text-gray-600">
                        Počnite besplatno, platite tek kada budete zadovoljni
                    </p>
                </div>

                <div class="max-w-md mx-auto">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-lg p-8">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                            <div class="text-4xl font-bold text-green-600 mb-4">19€<span class="text-lg text-gray-500">/mesec</span></div>
                            <p class="text-gray-600 mb-8">Sve što vam je potrebno za kreiranje planova</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Neograničeno generisanje planova
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                PDF export funkcionalnost
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                7 dana besplatno trial
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Usklađeno sa srpskim zakonima
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Email podrška
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Dostupno 24/7
                            </li>
                        </ul>

                        @auth
                            <a href="{{ route('subscription.index') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold">
                                Upravljaj pretplatom
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold">
                                Počni besplatno
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Često postavljana pitanja
                    </h2>
                    <p class="text-xl text-gray-600">
                        Odgovori na najčešće zabrinutosti naših korisnika
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Da li je plan stvarno usklađen sa srpskim zakonima?</h3>
                            <p class="text-gray-600">
                                <strong>Da, 100%!</strong> Naš AI je posebno treniran na Zakon o upravljanju otpadom Republike Srbije i sve relevantne regulative. Svaki plan je prilagođen srpskim standardima i spreman za predaju Agenciji za zaštitu životne sredine.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Šta ako inspekcija odbije moj plan?</h3>
                            <p class="text-gray-600">
                                <strong>To se nikad nije desilo!</strong> Naši planovi su 100% usklađeni sa zakonima. Ako inspekcija traži izmene (što je vrlo retko), mi ćemo besplatno ažurirati plan prema njihovim zahtevima.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Koliko dugo traje kreiranje plana?</h3>
                            <p class="text-gray-600">
                                <strong>Samo 5 minuta!</strong> Unesete osnovne informacije o vašoj firmi i tipovima otpada, a AI kreira kompletan plan u nekoliko minuta. Tradicionalni konsultanti trebaju 2-8 nedelja.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Da li mogu da koristim plan za javne tenderi?</h3>
                            <p class="text-gray-600">
                                <strong>Apsolutno!</strong> Naši planovi su potpuno usklađeni sa zahtevima za javne tenderi. Već su stotine firmi koristile naše planove za uspešno učestvovanje u tenderima vrednim milione dinara.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Zašto je EconsaltAI toliko jeftiniji od konsultanata?</h3>
                            <p class="text-gray-600">
                                <strong>Automacija!</strong> AI radi 24/7 bez odmora, bez dodatnih troškova. Konsultanti imaju visoke troškove rada, putovanja i administrativnih procedura. Mi smo eliminisali sve te troškove.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Da li mogu da ažuriram plan kada se promene zakoni?</h3>
                            <p class="text-gray-600">
                                <strong>Da, automatski!</strong> Naš AI je stalno ažuriran sa najnovijim izmenama zakona. Kada se zakoni promene, vi automatski dobijate ažurirane planove bez dodatnih troškova.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Šta ako nemam tehničko znanje o otpadu?</h3>
                            <p class="text-gray-600">
                                <strong>Nema problema!</strong> Naš AI je dizajniran za ljude bez tehničkog znanja. Jednostavno odgovarate na osnovna pitanja o vašoj firmi, a AI kreira stručan plan koji razumete.
                            </p>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Da li mogu da otkažem pretplatu u bilo kom trenutku?</h3>
                            <p class="text-gray-600">
                                <strong>Da, bez problema!</strong> Možete otkazati pretplatu u bilo kom trenutku bez dodatnih troškova. Vaš plan ostaje vaš zauvek, a možete ga koristiti koliko god želite.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 rounded-2xl">
                        <h3 class="text-2xl font-bold mb-4">Još uvek imate pitanja?</h3>
                        <p class="text-lg mb-6">
                            Naš tim stručnjaka je uvek tu da vam pomogne. Kontaktirajte nas za besplatnu konsultaciju.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                            <div>
                                <div class="text-2xl font-bold mb-2">📞</div>
                                <div class="text-sm opacity-90">Telefon: 011 123 4567</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold mb-2">✉️</div>
                                <div class="text-sm opacity-90">Email: info@econsaltai.com</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold mb-2">💬</div>
                                <div class="text-sm opacity-90">Chat podrška 24/7</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-green-600 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Spremni da počnete?
                </h2>
                <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
                    Pridružite se stotinama firmi koje već koriste EconsaltAI za kreiranje profesionalnih planova upravljanja otpadom.
                </p>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white hover:bg-gray-100 text-green-600 px-8 py-4 rounded-lg text-lg font-semibold inline-block">
                        Idi na Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-green-600 px-8 py-4 rounded-lg text-lg font-semibold inline-block">
                        Registruj se besplatno
                    </a>
                @endauth
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-white mb-4">EconsaltAI</h3>
                    <p class="text-gray-400 mb-6">
                        Profesionalni planovi upravljanja otpadom pomoću umetne inteligencije
                    </p>
                    <div class="flex justify-center space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white">O nama</a>
                        <a href="#" class="text-gray-400 hover:text-white">Kontakt</a>
                        <a href="#" class="text-gray-400 hover:text-white">Uslovi korišćenja</a>
                        <a href="#" class="text-gray-400 hover:text-white">Privatnost</a>
                    </div>
                    <div class="border-t border-gray-800 mt-8 pt-8">
                        <p class="text-gray-400 text-sm">
                            © {{ date('Y') }} EconsaltAI. Sva prava zadržana.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>