<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $fillable=[
        "drink",
        "amount",
        "type_id",
        "package_id"
    ];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function drink(){
        return $this->hasMany(Drink::class);
    }
}
