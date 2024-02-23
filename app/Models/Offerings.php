<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offerings extends Model
{
    use HasFactory;
    public $table = 'offerings';
    public function transactions()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id','id');
    }

    public function ministries()
    {
        return $this->belongsTo(Ministries::class, 'id','ministry_id');
    }
}
