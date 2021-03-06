<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'code', 'raffle_id', 'purchase_id', 'status', 'notes'
    ];

    public function raffle()
    {
        return $this->belongsTo(Raffle::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
