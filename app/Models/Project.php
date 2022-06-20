<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avance;
use Kyslik\ColumnSortable\Sortable;

class Project extends Model
{
    use HasFactory,Sortable;
    protected $fillable = [
        'title', 
        'description', 
        'client_id', 
        'designer_id', 
        'eta',
        'estado',
        'final_file'
    ];
    public $sortable = [
        'title', 
        'estado', 
        'eta',
    ];
        public function Avance() {
        return $this->hasMany('App\Models\Avance');
    }
}
