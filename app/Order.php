<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function items(){
    	return $this->belongsToMany("\App\Item")->withPivot("quantity")->withTimestamps();
    }

    public function payment(){
    	return $this->belongsTo('\App\Payment');
    }

    public function status(){
    	return $this->belongsTo('\App\Status');
    }

    public function user(){
    	return $this->belongsTo('\App\User');
    }
}
