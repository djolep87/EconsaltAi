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
                    <form method="POST" action="{{ route('plans.update', $plan) }}">
                        @csrf
                        @method('PUT')

                        <!-- Company Name -->
                        <div class="mb-4">
                            <x-input-label for="company_name" value="Naziv firme" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" value="{{ old('company_name', $plan->company_name) }}" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>

                        <!-- Company Address -->
                        <div class="mb-4">
                            <x-input-label for="company_address" value="Adresa firme" />
                            <textarea id="company_address" name="company_address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required>{{ old('company_address', $plan->company_address) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('company_address')" />
                        </div>

                        <!-- Business Activity -->
                        <div class="mb-4">
                            <x-input-label for="business_activity" value="Delatnost firme" />
                            <x-text-input id="business_activity" class="block mt-1 w-full" type="text" name="business_activity" value="{{ old('business_activity', $plan->business_activity) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('business_activity')" />
                        </div>

                        <!-- Waste Types -->
                        <div class="mb-4">
                            <x-input-label for="waste_types" value="Tipovi otpada (označite sve koji se odnose na vašu firmu)" />
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                @foreach($wasteTypes as $key => $label)
                                    <div class="flex items-center">
                                        <input id="waste_type_{{ $key }}" type="checkbox" name="waste_types[]" value="{{ $key }}" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                               {{ in_array($key, old('waste_types', $plan->waste_types ?? [])) ? 'checked' : '' }}>
                                        <label for="waste_type_{{ $key }}" class="ms-2 text-sm text-gray-900">{{ $label }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('waste_types')" />
                        </div>

                        <!-- Waste Quantities -->
                        <div class="mb-6">
                            <x-input-label value="Procena količina otpada mesečno (u kilogramima)" />
                            <div class="mt-4 space-y-3" id="quantity-inputs">
                                @foreach($wasteTypes as $key => $label)
                                    <div class="bg-gray-50 p-4 rounded-lg border quantity-input-container" id="quantity_container_{{ $key }}" style="display: none;">
                                        <div class="flex items-center justify-between gap-4">
                                            <label for="quantity_{{ $key }}" class="text-sm font-medium text-gray-700 whitespace-nowrap">{{ $label }}:</label>
                                            <div class="flex items-center gap-3 flex-1 max-w-xs">
                                                <input type="number" id="quantity_{{ $key }}" name="waste_quantities[{{ $key }}]" 
                                                       value="{{ old('waste_quantities.'.$key, $plan->waste_quantities[$key] ?? '0') }}" 
                                                       min="0" step="1"
                                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-900 bg-white" 
                                                       placeholder="0">
                                                <span class="text-sm font-medium text-gray-500 whitespace-nowrap">kg/mesec</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                <!-- Message when no waste types are selected -->
                                <div id="no-inputs-message" class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                    <p class="text-sm text-blue-700">Označite tipove otpada iznad da biste videli polja za unos količina.</p>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('waste_quantities')" />
                        </div>

                        <!-- Contract with Operator -->
                        <div class="mb-4">
                            <x-input-label value="Da li imate ugovor sa operatorom za upravljanje otpadom?" />
                            <div class="mt-2 flex space-x-6">
                                <div class="flex items-center">
                                    <input id="has_contract_yes" type="radio" name="has_contract_with_operator" value="1" 
                                           class="text-indigo-600 focus:ring-indigo-500"
                                           {{ old('has_contract_with_operator', $plan->has_contract_with_operator ? '1' : '0') == '1' ? 'checked' : '' }}>
                                    <label for="has_contract_yes" class="ms-2 text-sm text-gray-900">Da</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="has_contract_no" type="radio" name="has_contract_with_operator" value="0" 
                                           class="text-indigo-600 focus:ring-indigo-500"
                                           {{ old('has_contract_with_operator', $plan->has_contract_with_operator ? '1' : '0') != '1' ? 'checked' : '' }}>
                                    <label for="has_contract_no" class="ms-2 text-sm text-gray-900">Ne</label>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('has_contract_with_operator')" />
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <x-input-label for="notes" value="Napomene (dodatne informacije o vašoj firmi i potrebama)" />
                            <textarea id="notes" name="notes" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" placeholder="Opišite dodatne detalje o vašoj firmi, specifičnim potrebama za upravljanje otpadom, itd...">{{ old('notes', $plan->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end">
                            <a href="{{ route('plans.show', $plan) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-4">
                                Otkaži
                            </a>
                            <x-primary-button>
                                Sačuvaj izmene
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide quantity inputs based on waste type checkbox selection
        document.addEventListener('DOMContentLoaded', function() {
            const wasteTypeCheckboxes = document.querySelectorAll('input[name="waste_types[]"]');
            const noInputsMessage = document.getElementById('no-inputs-message');
            
            function toggleQuantityInputs() {
                let hasVisibleInputs = false;
                
                wasteTypeCheckboxes.forEach(checkbox => {
                    const key = checkbox.value;
                    const quantityContainer = document.getElementById('quantity_container_' + key);
                    const quantityInput = document.getElementById('quantity_' + key);
                    
                    if (quantityContainer && quantityInput) {
                        if (checkbox.checked) {
                            // Show the quantity input container
                            quantityContainer.style.display = 'block';
                            quantityContainer.classList.add('bg-gray-50');
                            quantityContainer.classList.remove('opacity-60', 'bg-gray-100');
                            
                            // Enable the input
                            quantityInput.disabled = false;
                            hasVisibleInputs = true;
                        } else {
                            // Hide the quantity input container
                            quantityContainer.style.display = 'none';
                            quantityInput.value = '0';
                        }
                    }
                });
                
                // Show/hide the no inputs message
                if (noInputsMessage) {
                    if (hasVisibleInputs) {
                        noInputsMessage.style.display = 'none';
                    } else {
                        noInputsMessage.style.display = 'block';
                    }
                }
            }
            
            // Add event listeners to checkboxes
            wasteTypeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleQuantityInputs);
            });
            
            // Initial state - show inputs for pre-checked items (existing plan data or form validation errors)
            setTimeout(function() {
                toggleQuantityInputs();
            }, 100);
        });
    </script>
</x-app-layout>
