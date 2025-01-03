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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'credit_limits';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idLimiteDeCredito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idCliente',

        'vrLimite',
        'vrUtilizado',
        'vrReservado',
        'vrDisponivel',
    ];

    /**
     * Get the customer that owns the credit limit.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idCliente', 'idCliente');
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
    public function updateAvailable(): void
    {
        $this->vrDisponivel = $this->vrLimite - ($this->vrUtilizado + $this->vrReservado);
    }
}
