<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public $timestamps=false; 

    
        public function drink(){
            return [
                "id" => $this->id,
                "típus" => $this->type
            ];
        }
    
}
