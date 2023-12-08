<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscription_user extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'subscription_users';
    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function subscription()
    {
        return $this->belongsTo(subscription::class, 'id_subscription');
    }
}
