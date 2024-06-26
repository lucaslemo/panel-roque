<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CreditLimit extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'limit',
        'used',
        'reserved',
        'available',
        'get_organization_id',
    ];

    /**
     * Get the organization that owns the credit limit.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'get_organization_id', 'id');
    }

    /**
     * Log the model events.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        // Chain fluent methods for configuration options
        return LogOptions::defaults()
            ->logOnly(['*']);
    }

    /**
     * Update the available value.
     */
    public function updateAvalible(): void
    {
        $this->available = $this->limit - ($this->used + $this->reserved);
    }
}
