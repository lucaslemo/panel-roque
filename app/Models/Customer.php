<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idCliente';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'extCliente',
        'nmCliente',
        'tpCliente',
        'emailCliente',
        'codCliente',
    ];

    /**
     * The users that belong to the customer.
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'users_has_customers',
            'idCliente',
            'idUsuario',
        )->withTimestamps();
    }

    /**
     * Get the credit limit associated with the customer.
     */
    public function creditLimit(): HasOne
    {
        return $this->hasOne(CreditLimit::class, 'idCliente', 'idCliente');
    }

    /**
     * Get the invoices for the customer.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'idCliente', 'idCliente');
    }

    /**
     * Get the orders for the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'idCliente', 'idCliente');
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
