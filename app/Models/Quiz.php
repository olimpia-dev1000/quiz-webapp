<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
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

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order_number', 'asc');
    }
}
