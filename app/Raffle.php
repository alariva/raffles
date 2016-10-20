<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use KLaude\EloquentPreferences\HasPreferences;

class Raffle extends Model
{
    use HasPreferences;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'redirect_url', 'opened_at', 'closed_at', 'range', 'email',
    ];

    protected $dates = [
        'opened_at', 'closed_at',
    ];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
