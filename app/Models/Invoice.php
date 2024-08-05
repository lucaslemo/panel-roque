<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idConta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idCliente',

        'extCliente',
        'extConta',
        'idPedidoCabecalho',
        'idFilial',
        'nmVendedor',
        'statusConta',
        'nmSituacao',
        'tpCobranca',
        'dtParcela',
        'numDuplicata',
        'dtEmissao',
        'dtVencimento',
        'dtPagamento',
        'vrBruto',
        'vrLiquido',
        'vrAtualizado',
        'vrPago',
        'isBoleto',
        'nmArquivo',
    ];

    /**
     * Get the customer that owns the invoice.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'idCliente', 'idCliente');
    }

    /**
     * Get the order that owns the invoice.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'idPedidoCabecalho', 'idPedidoCabecalho');
    }

    /**
     * Get the company that owns the invoice.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'idFilial', 'idFilial');
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
