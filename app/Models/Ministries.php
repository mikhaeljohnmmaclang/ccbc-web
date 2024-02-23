<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministries extends Model
{
    use HasFactory;
    public $table = 'ministries';
    public function OfferingsMade(){
        return $this->hasMany(Offerings::class,'ministy_id','id');
    }
}
