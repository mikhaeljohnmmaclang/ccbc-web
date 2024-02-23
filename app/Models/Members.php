<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;
    public $table = 'members';

    // public function TransactionsMade(){
    //     return $this->hasMany(Transactions::class,'member_id');
    // }

}
