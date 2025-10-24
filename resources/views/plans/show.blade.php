<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plan upravljanja otpadom - {{ $plan->company_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('plans.edit', $plan) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Izmeni plan
                </a>
                <a href="{{ route('plan.generator') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    AI Generator
                </a>
                <a href="{{ route('plans.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nazad na listu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Info Message -->
            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Plan Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Status plana</h3>
                            <p class="text-sm text-gray-600">
                                @if($plan->status === 'completed')
                                    Plan je završen i spreman za preuzimanje
                                @elseif($plan->status === 'generating')
                                    AI plan se trenutno generiše, molimo sačekajte...
                                @elseif($plan->status === 'generated')
                                    AI plan je generisan
                                @else
                                    Plan je u draft stanju
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full
                                @if($plan->status === 'completed') bg-green-100 text-green-800
                                @elseif($plan->status === 'generating') bg-yellow-100 text-yellow-800
                                @elseif($plan->status === 'generated') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $plan->status_label }}
                            </span>
                            @if($plan->status === 'draft')
                                <form method="POST" action="{{ route('plans.generate', $plan) }}" class="inline ml-3">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Generiši AI plan
                                    </button>
                                </form>
                            @elseif($plan->status === 'generating')
                                <span class="ml-3 text-sm text-gray-600">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Generiše se...
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Informacije o firmi</h3>
                        <a href="{{ route('plans.edit', $plan) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            Izmeni informacije
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naziv firme</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $plan->company_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Delatnost</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $plan->business_activity }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Adresa</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $plan->company_address }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ugovor sa operatorom</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $plan->has_contract_with_operator ? 'Da' : 'Ne' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kreiran</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $plan->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waste Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tipovi i količine otpada</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($plan->waste_types as $wasteType)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-900">{{ $wasteTypes[$wasteType] }}</span>
                                    <span class="text-lg font-bold text-blue-600">
                                        {{ $plan->waste_quantities[$wasteType] ?? 0 }} kg/mesec
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($plan->notes)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Napomene</h3>
                    <p class="text-sm text-gray-900 whitespace-pre-line">{{ $plan->notes }}</p>
                </div>
            </div>
            @endif

            <!-- AI Generated Plan -->
            @if($plan->ai_generated_plan)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">AI generisani plan upravljanja otpadom</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('plans.pdf.view', $plan) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Pregledaj PDF
                            </a>
                            <a href="{{ route('plans.pdf', $plan) }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Preuzmi PDF
                            </a>
                        </div>
                    </div>
                    <div class="prose max-w-none">
                        {!! nl2br(e($plan->ai_generated_plan)) !!}
                    </div>
                </div>
            </div>
            @elseif($plan->status === 'generating')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">AI plan se generiše</h3>
                    <p class="text-gray-600 mb-4">Molimo sačekajte, AI plan se trenutno generiše za vašu firmu...</p>
                    <div class="flex justify-center">
                        <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            @elseif($plan->status === 'draft')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">AI plan još nije generisan</h3>
                    <p class="text-gray-600 mb-4">Kliknite na dugme "Generiši AI plan" da kreirate plan za vašu firmu.</p>
                    <form method="POST" action="{{ route('plans.generate', $plan) }}">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Generiši AI plan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
