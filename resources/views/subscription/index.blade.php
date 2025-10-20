<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pretplata') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Current Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Trenutni status pretplate</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">
                                @if($subscribed)
                                    <span class="text-green-600">Aktivna</span>
                                @elseif($onTrial)
                                    <span class="text-blue-600">Trial</span>
                                @else
                                    <span class="text-red-600">Neaktívna</span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">Status</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">
                                @if($trialEndsAt)
                                    {{ $trialEndsAt->format('d.m.Y') }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                @if($onTrial)
                                    Trial završava
                                @elseif($subscribed && $subscription)
                                    Sledeće naplaćivanje
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">19€</div>
                            <div class="text-sm text-gray-600">Mesečno</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Subscribe / Renew -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            @if($subscribed)
                                Upravljaj pretplatom
                            @else
                                Aktiviraj pretplatu
                            @endif
                        </h3>
                        
                        @if(!$subscribed)
                            <div class="space-y-4">
                                <div class="text-sm text-gray-600">
                                    <p class="mb-3">Pretplata uključuje:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Neograničeno generisanje AI planova</li>
                                        <li>PDF export funkcionalnost</li>
                                        <li>Priprema za sve tipove otpada</li>
                                        <li>24/7 pristup platformi</li>
                                        <li>Email podrška</li>
                                    </ul>
                                </div>
                                
                                <form method="POST" action="{{ route('subscription.checkout') }}">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                                        Počni sa pretplatom - 19€/mesec
                                    </button>
                                </form>
                                
                                <p class="text-xs text-gray-500 text-center">
                                    Možete otkazati u bilo kom trenutku
                                </p>
                            </div>
                        @else
                            <div class="space-y-4">
                                <div class="text-sm text-gray-600">
                                    <p>Vaša pretplata je aktivna. Možete upravljati načinom plaćanja i billing informacijama.</p>
                                </div>
                                
                                <div class="flex space-x-3">
                                    <a href="{{ route('subscription.billing') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                        Upravljaj načinom plaćanja
                                    </a>
                                </div>
                                
                                @if($subscription && $subscription->onGracePeriod())
                                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                                        <p class="text-sm">Vaša pretplata je otkazana i ističe {{ $subscription->ends_at->format('d.m.Y') }}.</p>
                                        <form method="POST" action="{{ route('subscription.resume') }}" class="mt-2">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Nastavi pretplatu
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('subscription.cancel') }}" onsubmit="return confirm('Da li ste sigurni da želite da otkažete pretplatu?')">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Otkaži pretplatu
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Plan Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Plan detalji</h3>
                        
                        <div class="space-y-4">
                            <div class="border-b pb-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Plan</span>
                                    <span class="text-gray-600">Professional</span>
                                </div>
                            </div>
                            
                            <div class="border-b pb-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Cena</span>
                                    <span class="text-gray-600">19€ mesečno</span>
                                </div>
                            </div>
                            
                            <div class="border-b pb-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Trial period</span>
                                    <span class="text-gray-600">7 dana besplatno</span>
                                </div>
                            </div>
                            
                            @if($subscription)
                            <div class="border-b pb-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Registrovano</span>
                                    <span class="text-gray-600">{{ $subscription->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>
                            
                            @if($subscription->stripe_status)
                            <div class="border-b pb-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium">Status</span>
                                    <span class="text-gray-600 capitalize">{{ $subscription->stripe_status }}</span>
                                </div>
                            </div>
                            @endif
                            @endif
                            
                            <div class="pt-3">
                                <p class="text-xs text-gray-500">
                                    Svi planovi uključuju neograničeno generisanje planova upravljanja otpadom, 
                                    PDF export funkcionalnost i email podršku.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Information -->
            @if($onTrial || $subscribed)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Korišćenje</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $user->wasteManagementPlans()->count() }}</div>
                            <div class="text-sm text-gray-600">Kreiranih planova</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $user->wasteManagementPlans()->where('status', 'generated')->count() }}</div>
                            <div class="text-sm text-gray-600">Generisanih planova</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $user->wasteManagementPlans()->where('status', 'completed')->count() }}</div>
                            <div class="text-sm text-gray-600">Preuzetih PDF-ova</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
