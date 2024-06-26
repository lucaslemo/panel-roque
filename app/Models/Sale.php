<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Sale extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch',
        'delivery_type',
        'order_date',
        'rca',
        'billing_date',
        'value',
        'cob',
        'status',
        'delivery_date',
        'type',
        'delivery_status',
        'creation_date',
        'purchase_order',
        'get_organization_id',
    ];

    /**
     * Get the billsToReceive for the blog sale.
     */
    public function billsToReceive(): HasMany
    {
        return $this->hasMany(BillToReceive::class, 'get_sale_id', 'id');
    }

    /**
     * Get the organization that owns the sale.
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
}
