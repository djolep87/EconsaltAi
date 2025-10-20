<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waste_management_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name');
            $table->text('company_address');
            $table->string('business_activity');
            $table->json('waste_types'); // ['papir', 'plastika', 'metal', 'staklo', 'elektronski', 'opasan']
            $table->json('waste_quantities'); // {"papir": 100, "plastika": 50, ...}
            $table->boolean('has_contract_with_operator')->default(false);
            $table->text('notes')->nullable();
            $table->longText('ai_generated_plan')->nullable();
            $table->string('status')->default('draft'); // draft, generated, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_management_plans');
    }
};
