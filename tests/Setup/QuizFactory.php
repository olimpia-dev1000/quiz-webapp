<?php

namespace Tests\Setup;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

class QuizFactory
{
    protected $questionsCount = 0;
    protected $user;

    public function withQuestions($count)
    {
        $this->questionsCount = $count;
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
        Question::factory($this->questionsCount)->create(['quiz_id' => $quiz->id]);
        return $quiz;
    }
}
