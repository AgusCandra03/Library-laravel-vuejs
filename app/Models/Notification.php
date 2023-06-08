<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'is_read', 'transaction_id', 'member_id'];

    public function transactions()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_id');
    }
    public function members()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }
}
