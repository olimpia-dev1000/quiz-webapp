<?php

namespace Tests\Setup;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

class QuizFactory
{
    protected $questionsCount = 0;
    protected $answers = false;
    protected $user;

    public function withQuestions($count)
    {
        $this->questionsCount = $count;
        return $this;
    }

    public function withAnswers($answer)
    {
        $this->answers = $answer;
        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;
        return $this;
    }

    public function create()
    {
        $quiz = Quiz::factory()->create(['owner_id' => $this->user ?? User::factory()]);
        $questionType = $this->answers ? 'multiple_choice' : 'true_false';
        $question = Question::factory($this->questionsCount)->create(['quiz_id' => $quiz->id, 'question_type' => $questionType]);

        if ($this->answers && $question->count() > 0) {
            foreach ($question as $qs) {
                Answer::factory(3)->create(['question_id' => $qs->id]);
                Answer::factory(1)->create(['question_id' => $qs->id, 'is_correct' => true]);
            }
        }
        return $quiz;
    }
}
