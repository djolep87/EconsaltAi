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
        Schema::table('waste_management_plans', function (Blueprint $table) {
            $table->string('pib', 20)->nullable()->after('business_activity');
            $table->integer('broj_zaposlenih')->nullable()->after('pib');
            $table->decimal('povrsina_objekta', 10, 2)->nullable()->after('broj_zaposlenih');
            $table->text('vrste_otpada')->nullable()->after('povrsina_objekta');
            $table->text('nacin_skladistenja')->nullable()->after('vrste_otpada');
            $table->text('operateri')->nullable()->after('nacin_skladistenja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('waste_management_plans', function (Blueprint $table) {
            $table->dropColumn(['pib', 'broj_zaposlenih', 'povrsina_objekta', 'vrste_otpada', 'nacin_skladistenja', 'operateri']);
        });
    }
};
