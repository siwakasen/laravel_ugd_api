<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_item extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'type_items';
    protected $fillable = [
        'name',
        'size',
        'customize',
    ];

    public function items()
    {
        return $this->hasMany(Item::class, 'id_type');
    }
}
