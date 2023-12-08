<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'items';
    protected $fillable = [
        'id_type',
        'name',
        'photo',
        'price',
    ];

    public function typeitem()
    {
        return $this->belongsTo(TypeItem::class, 'id_type');
    }
}
