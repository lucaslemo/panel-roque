<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BillToReceive extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bills_to_receive';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'branch',
        'cob',
        'duplicate',
        'portion_date',
        'total_gross',
        'ref',
        'emission_date',
        'expiry_date',
        'payment_date',
        'status',
        'situation',
        'net_total',
        'updated_total',
        'amount_paid',
        'rca',
        'check',
        'get_organization_id',
        'get_sale_id',
    ];

    /**
     * Get the organization that owns the bill to receive.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'get_organization_id', 'id');
    }

    /**
     * Get the sale that owns the bill to receive.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'get_sale_id', 'id');
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
