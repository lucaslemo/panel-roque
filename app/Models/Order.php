<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idPedidoCabecalho';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idCliente',
        'idFilial',

        'extCliente',
        'extPedido',
        'nmVendedor',
        'tpEntrega',
        'statusPedido',
        'statusEntrega',
        'dtPedido',
        'dtFaturamento',
        'dtEntrega',
        'vrTotal',
        'numOrdemCompra',
        'nmArquivoDetalhes',
        'nmArquivoNotaFiscal',
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idCliente', 'idCliente');
    }

    /**
     * Get the company that owns the order.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'idFilial', 'idFilial');
    }

    /**
     * Get the invoices for the order.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'idPedidoCabecalho', 'idPedidoCabecalho');
    }

    /**
     * Get the payment types for the order.
     */
    public function paymentTypes(): HasMany
    {
        return $this->hasMany(PaymentType::class, 'idPedidoCabecalho', 'idPedidoCabecalho');
    }

    /**
     * Get the order history for the order.
     */
    public function orderHistory(): HasMany
    {
        return $this->hasMany(OrderHistory::class, 'idPedidoCabecalho', 'idPedidoCabecalho');
    }

    /**
     * Parse the date.
     */
    public function getDtPedidoAttribute($date)
    {
        return Carbon::parse($date);
    }

    /**
     * Parse the date.
     */
    public function getDtFaturamentoAttribute($date)
    {
        return Carbon::parse($date);
    }

    /**
     * Parse the delivery type.
     */
    public function getTpEntregaAttribute($value)
    {
        if ($value === 'FOB') {
            return 'Withdrawal';
        } else if ($value === 'CIF') {
            return 'Delivery';
        }
        return $value;
    }

    /**
     * Parse the delivery type.
     */
    public function getStatusColor()
    {
        switch ($this->statusEntrega) {
            case 'Em trânsito':
                return 'yellow';
            case 'Montado':
                return 'primary';
            case 'Reservado':
                return 'red';
            case 'Devolvido':
                return 'red';
            case 'Cancelado':
                return 'stone';
            case 'Entregue':
                return 'green';
            default:
                return 'stone';
        }
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
