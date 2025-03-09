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

    public function test_it_belongs_to_a_question()
    {

        $quiz = app(QuizFactory::class)->withQuestions(3)->withAnswers(true)->ownedBy($this->signIn())->create();
        $answer = $quiz->questions()->first()->answers()->first();

        $this->assertInstanceOf(Answer::class, $answer);
    }

    public function test_question_owner_can_add_answers()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->withAnswers(true)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $answer = $question->answers()->firstOrFail();

        $this->delete(route('answers.destroy', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]));

        $answer = app(AnswerFactory::class)->raw(['question_id' => $question->id]);

        $this->post(route('answers.store', [
            'quiz' => $quiz->id,
            'question' => $question->id
        ]), $answer)->assertStatus(302);

        $this->assertDatabaseHas('answers', $answer);
    }

    public function test_it_total_count_per_multiple_choice_question_is_4()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->withAnswers(true)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $this->expectException(\Exception::class);
        app(AnswerFactory::class)->create(['question_id' => $question->id]);
    }

    public function test_it_total_count_per_true_false_question_is_2()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $this->expectException(\Exception::class);
        app(AnswerFactory::class)->create(['question_id' => $question->id]);
    }

    public function test_it_is_correct_count_can_not_be_more_than_1()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $this->expectException(\Exception::class);
        app(AnswerFactory::class)->count(2)->create(['question_id' => $question->id, 'is_correct' => true]);
    }

    public function test_user_cannot_add_5_answers()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->withAnswers(true)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $answer = app(AnswerFactory::class)->raw(['question_id' => $question->id]);

        $this->post(route('answers.store', [
            'quiz' => $quiz->id,
            'question' => $question->id
        ]), $answer)->assertStatus(500);
    }

    public function test_it_can_be_updated_by_multiple_choice_question()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->withAnswers(true)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $answer = $question->answers()->firstOrFail();

        $this->get(route('answers.edit', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]))->assertStatus(200);

        $this->patch(route('answers.update', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]), ['answer_text' => 'Text updated']);


        $this->assertDatabaseHas('answers', [
            'answer_text' => 'Text updated'
        ]);
    }

    public function test_its_text_can_not_be_updated_by_false_true_question()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();

        $question = $quiz->questions()->firstOrFail();

        $answer = $question->answers()->firstOrFail();

        $response = $this->patchJson(route('answers.update', [
            'quiz' => $quiz->id,
            'question' => $question->id,
            'answer' => $answer->id
        ]), ['answer_text' => 'Text updated']);

        $response->assertStatus(500);
    }

    public function test_can_not_be_deleted_by_false_true_question()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->ownedBy($this->signIn())->create();

        $question = $quiz->questions()->firstOrFail();

        $answer = $question->answers()->firstOrFail();

        $response = $this->deleteJson(route('answers.destroy', [
            'quiz' => $quiz->id,
            'question' => $question->id,
            'answer' => $answer->id
        ]));

        $response->assertStatus(405);
    }

    public function test_it_can_be_deleted()
    {
        $quiz = app(QuizFactory::class)->withQuestions(1)->withAnswers(true)->ownedBy($this->signIn())->create();
        $question = $quiz->questions()->firstOrFail();

        $answer = $question->answers()->firstOrFail();

        $this->delete(route('answers.destroy', ['quiz' => $quiz->id, 'question' => $question->id, 'answer' => $answer->id]))->assertStatus(302);
    }
}
