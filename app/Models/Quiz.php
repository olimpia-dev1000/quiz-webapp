<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{

    protected $guarded = [];

    /** @use HasFactory<\Database\Factories\QuizFactory> */
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
