<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Answer;
use Database\Factories\AnswerFactory;
use Tests\Setup\QuizFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\ExpectationFailedException;

use function PHPUnit\Framework\assertEquals;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function it_belongs_to_a_question()
    {

        $quiz = app(QuizFactory::class)->withQuestions(3)->withAnswers(true)->ownedBy($this->signIn())->create();
        $answer = $quiz->questions()->first()->answers()->first();

        $this->assertInstanceOf(Answer::class, $answer);
    }

    public function test_question_owner_can_add_answers()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $this->get(route('answers.create', ['quiz' => $quiz->id, 'question' => $question->id]))->assertStatus(200);

        $answer = app(AnswerFactory::class)->raw(['question_id' => $question->id]);

        $this->post(route('answers.store', [
            'quiz' => $quiz->id,
            'question' => $question->id
        ]), $answer)->assertStatus(302);

        $this->assertDatabaseHas('answers', ['answer_text' => $question->answers()->first()->answer_text]);
    }

    public function test_it_total_count_per_question_is_4()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        app(AnswerFactory::class)->count(4)->create(['question_id' => $question->id]);

        $this->expectException(\Exception::class);
        app(AnswerFactory::class)->create(['question_id' => $question->id]);
    }

    public function test_user_cannot_add_5_answers()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        app(AnswerFactory::class)->count(4)->create(['question_id' => $question->id]);

        $answer = app(AnswerFactory::class)->raw(['question_id' => $question->id]);

        $this->post(route('answers.store', [
            'quiz' => $quiz->id,
            'question' => $question->id
        ]), $answer)->assertStatus(500);
    }

    // TODO

    // public function test_one_of_the_answers_need_to_be_correct() 
    // {

    // }

    public function test_it_can_be_updated()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        app(AnswerFactory::class)->count(4)->create(['question_id' => $question->id]);

        $answer = $question->answers()->firstOrFail();

        $this->get(route('answers.edit', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]))->assertStatus(200);

        $this->patch(route('answers.update', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]), ['answer_text' => 'Text updated']);


        $this->assertDatabaseHas('answers', [
            'answer_text' => 'Text updated'
        ]);
    }

    public function test_it_can_be_deleted()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        app(AnswerFactory::class)->count(4)->create(['question_id' => $question->id]);

        $answer =  $question->answers()->firstOrFail();

        $this->delete(route('answers.destroy', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]))->assertStatus(302);
    }
}
