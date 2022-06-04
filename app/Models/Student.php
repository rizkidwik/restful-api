<?php

namespace App\Models;

use App\Models\Score;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'alamat', 'no_telp'];

    public function score()
    {
        return $this->hasMany(Score::class,'student_id');
    }
}
