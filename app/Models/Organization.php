<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Organization extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The users that belong to the organization.
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'users_has_organizations',
            'get_organization_id',
            'get_user_id',
        );
    }

    /**
     * Get the credit limit associated with the organization.
     */
    public function creditLimit(): HasOne
    {
        return $this->hasOne(CreditLimit::class, 'get_organization_id', 'id');
    }

    /**
     * Get the billsToReceive for the blog organization.
     */
    public function billsToReceive(): HasMany
    {
        return $this->hasMany(BillToReceive::class, 'get_organization_id', 'id');
    }

    /**
     * Get the sales for the blog organization.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'get_organization_id', 'id');
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
