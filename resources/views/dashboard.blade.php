<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Dobrodošli, {{ $user->name }}!</h3>
                            <p class="text-gray-600">Generišite planove upravljanja otpadom za vašu firmu.</p>
                            <div class="mt-2">
                                @if($user->subscribed())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Premium aktivna
                                    </span>
                                @elseif($user->onTrial())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Trial - {{ max(0, (int) round(now()->diffInDays($user->trial_ends_at, false))) }} dana
                                    </span>
                                    <a href="{{ route('subscription.index') }}" class="ml-2 text-blue-600 hover:text-blue-800 text-sm">Aktiviraj pretplatu</a>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Besplatna verzija
                                    </span>
                                    <a href="{{ route('subscription.index') }}" class="ml-2 text-blue-600 hover:text-blue-800 text-sm">Aktiviraj pretplatu</a>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('plans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Kreiraj novi plan
                            </a>
                            @if(!$user->subscribed())
                                <a href="{{ route('subscription.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Pretplata
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Plans -->
            @if($plans->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Poslednji planovi</h3>
                        <div class="space-y-4">
                            @foreach($plans as $plan)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $plan->company_name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $plan->business_activity }}</p>
                                            <p class="text-xs text-gray-500">Kreiran: {{ $plan->created_at->format('d.m.Y H:i') }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($plan->status === 'completed') bg-green-100 text-green-800
                                                @elseif($plan->status === 'generating') bg-yellow-100 text-yellow-800
                                                @elseif($plan->status === 'generated') bg-blue-100 text-blue-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $plan->status_label }}
                                            </span>
                                            <a href="{{ route('plans.show', $plan) }}" class="text-blue-600 hover:text-blue-800 text-sm">Pogledaj</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(auth()->user()->wasteManagementPlans()->count() > 5)
                            <div class="mt-4">
                                <a href="{{ route('plans.index') }}" class="text-blue-600 hover:text-blue-800">Vidi sve planove</a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Nemate kreiranih planova</h3>
                        <p class="text-gray-600 mb-4">Počnite sa kreiranjem prvog plana upravljanja otpadom.</p>
                        <a href="{{ route('plans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Kreiraj prvi plan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
