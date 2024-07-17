<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Update extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'updates';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idAtualizacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nmEntidade',
        'numTotalDados',
    ];

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
