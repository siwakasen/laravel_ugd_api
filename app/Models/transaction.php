<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'id_user',
        'id_restaurant',
        'id_voucher',
        'address_on_trans',
        'subtotal',
        'delivery_fee',
        'order_fee',
        'total',
        'status',
        'paymentMethod',
        'datetime',
    ];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function resto()
    {
        return $this->belongsTo(restaurant::class, 'id_restaurant');
    }
}
