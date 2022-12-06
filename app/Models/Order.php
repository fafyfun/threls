<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','address','contact'];


    public function user()
    {
        return $this->belongsTo('App\User');

    }

    public function products(){
        return $this->belongsToMany('App\Products')->withPivot();
    }

}
