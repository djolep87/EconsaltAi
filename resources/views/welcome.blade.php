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
                    <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                        Generišite profesionalne planove upravljanja otpadom za vašu firmu pomoću umetne inteligencije. 
                        Jednostavno unesite podatke, a AI kreira kompletnu strategiju.
                    </p>
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
                                7 dana besplatno
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Email podrška
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