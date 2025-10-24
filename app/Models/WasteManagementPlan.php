<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteManagementPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_address',
        'business_activity',
        'waste_types',
        'waste_quantities',
        'has_contract_with_operator',
        'notes',
        'ai_generated_plan',
        'status',
        'pib',
        'broj_zaposlenih',
        'povrsina_objekta',
        'vrste_otpada',
        'nacin_skladistenja',
        'operateri',
    ];

    protected $casts = [
        'waste_types' => 'array',
        'waste_quantities' => 'array',
        'has_contract_with_operator' => 'boolean',
    ];

    /**
     * Get the user that owns the plan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get available waste types.
     */
    public static function getAvailableWasteTypes()
    {
        return [
            'papir' => 'Papir',
            'plastika' => 'Plastika',
            'metal' => 'Metal',
            'staklo' => 'Staklo',
            'elektronski' => 'Elektronski',
            'opasan' => 'Opasan otpad',
        ];
    }

    /**
     * Get available statuses.
     */
    public static function getAvailableStatuses()
    {
        return [
            'draft' => 'Draft',
            'generating' => 'Generiše se',
            'generated' => 'Generisan',
            'completed' => 'Završen',
        ];
    }

    /**
     * Get status label in Serbian.
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'generating' => 'Generiše se',
            'generated' => 'Generisan',
            'completed' => 'Završen',
        ];

        return $statuses[$this->status] ?? $this->status;
    }
}
