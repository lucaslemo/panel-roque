<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Branch extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'branches';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idFilial';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nmFilial',
    ];

    /**
     * Get the invoices for the branch.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'idFilial', 'idFilial');
    }

    /**
     * Get the orders for the branch.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'idFilial', 'idFilial');
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
