<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\User;

class Avance extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'description',
        'file',
        'project_id',
    ];
    public function Project() {
        return $this->belongsTo(Project::class);
    }
        public function User() {
        return $this->belongsTo(User::class);
    }
}
