<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    /** @use HasFactory<\Database\Factories\AnswerFactory> */
    use HasFactory;

    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($answer) {
            if ($answer->question->answers()->count() >= 4) {
                throw new \Exception('You can only have a maximum of 4 answers per question');
            }
        });
    }
}
