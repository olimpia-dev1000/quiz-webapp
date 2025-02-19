<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{

    protected $guarded = [];
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($question) {
            $lastPosition = static::max('order_number');
            $question->order_number = $lastPosition ? $lastPosition + 1 : 1;
        });
    }
}
