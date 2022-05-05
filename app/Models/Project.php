<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avance;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'description', 
        'client_id', 
        'designer_id', 
        'eta',
        'estado',
        'final_file'
    ];
        public function Avance() {
        return $this->hasMany('Avance');
    }
}
