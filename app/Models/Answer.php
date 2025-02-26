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
            $answerCount = $answer->question->answers()->count(); // Avoid multiple queries

            if ($answerCount >= 4) {
                throw new \Exception('You can only have a maximum of 4 answers per question.');
            }

            if ($answer->question->question_type === 'true_false' && $answerCount >= 2) {
                throw new \Exception('You can only have a maximum of 2 answers for a true/false question.');
            }

            if ($answer->is_correct && $answer->question->answers()->where('is_correct', true)->exists()) {
                throw new \Exception('Only one answer can be marked as correct.');
            }
        });

        static::updating(function ($answer) {
            if ($answer->question->question_type === 'true_false' && $answer->isDirty('answer_text')) {
                throw new \Exception('The text of a true/false answer cannot be updated.');
            }
        });
    }
}
