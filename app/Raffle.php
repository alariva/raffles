<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'redirect_url', 'closed_at', 'range',
    ];

    protected $dates = [
        'closed_at',
    ];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
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
