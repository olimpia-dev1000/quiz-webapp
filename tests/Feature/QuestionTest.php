<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\QuizFactory;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_a_quizz()
    {

        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();

        $this->assertInstanceOf(Quiz::class, $quiz);

        $this->get("/quizzes/{$quiz->id}/questions")->assertSee($quiz->questions[0]->text);
    }

    public function test_its_question_type_can_be_changed()
    {
        $quiz = app(QuizFactory::class)->withQuestions(5)->ownedBy($this->signIn())->create();

        $this->assertEquals(count($quiz->questions), 5);

        $this->patch("/quizzes/{$quiz->id}/questions/{$quiz->questions[0]->id}", ['question_type' => 'multiple_choice']);

        $this->assertDatabaseHas('questions', ['question_type' => 'multiple_choice']);
    }

    public function test_it_can_be_deleted()
    {
        $quiz = app(QuizFactory::class)->withQuestions(5)->ownedBy($this->signIn())->create();

        $this->delete("/quizzes/{$quiz->id}/questions/{$quiz->questions[0]->id}");

        $quiz->refresh();

        $this->assertEquals(count($quiz->questions), 4);
    }

    public function test_true_false_question_has_automatically_2_answers_by_creating_it()
    {
        $this->withoutExceptionHandling();

        $quiz = app(QuizFactory::class)->ownedBy($this->signIn())->create();

        $attr = [
            'question_text' => 'Test question',
            'question_type' => 'true_false',
        ];

        $this->post(route('questions.store', ['quiz' => $quiz->id]), $attr);

        $this->assertDatabaseHas('questions', $attr);

        $this->assertEquals(count($quiz->questions[0]->answers), 2);
    }
}
