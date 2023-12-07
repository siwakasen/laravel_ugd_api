<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksis';
    protected $fillable = [
        'id_transaksi',
        'id_item',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item');
    }

    public function transaction()
    {
        return $this->belongsTo(transaction::class, 'id_transaksi');
    }
}
