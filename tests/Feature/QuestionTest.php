<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_quizz()
    {
        $question = Question::factory()->create();

        $this->assertInstanceOf(Quiz::class, $question->quiz);
    }
}
