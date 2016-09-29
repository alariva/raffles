<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'details', 'expires_at', 'hash', 'status', 'raffle_id', 'url',
    ];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}
