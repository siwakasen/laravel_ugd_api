<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rating extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ratings';
    protected $fillable = [
        'id_transaksi',
        'stars',
        'notes',
    ];

    public function transaction()
    {
        return $this->belongsTo(transaction::class, 'id_transaksi', 'id');
    }
}
