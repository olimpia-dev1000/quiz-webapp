<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $guarded = [];
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
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
