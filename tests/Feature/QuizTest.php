<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizTest extends TestCase
{

    use RefreshDatabase;

    public function test_authenticated_user_can_create_a_quiz()
    {
        $this->signIn();

        $quiz = Quiz::factory()->raw();

        $this->post('/quizzes', $quiz)->assertRedirect('/');

        $this->assertDatabaseHas('quizzes', [
            'title' => $quiz['title'],
            'owner_id' => Auth::id()
        ]);
    }

    public function test_authenticated_user_can_view_a_quiz_form()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $this->get('/quizzes/create')->assertStatus(200)->assertSeeText('Create new quiz');
    }

    public function test_user_can_update_a_quiz()
    {
        $this->signIn();

        $quiz = Quiz::factory()->raw();
        $this->post('/quizzes', $quiz);

        $quizData = Auth::user()->quizzes()->latest()->first();
        $this->patch("/quizzes/{$quizData->id}", $attr = ['title' => 'title Changed']);

        $this->assertDatabaseHas('quizzes', $attr);
    }

    public function test_user_can_delete_a_quiz()
    {

        $this->withoutExceptionHandling();
        $this->signIn();
        $quiz = Quiz::factory()->raw();
        $this->post('/quizzes', $quiz);
        $quizData = Auth::user()->quizzes()->latest()->first();
        $this->delete("/quizzes/{$quizData->id}")->assertStatus(302);
    }

    public function test_quiz_requires_a_title()
    {

        $this->expectException(\Illuminate\Database\QueryException::class);

        $quiz = Quiz::factory()->create(['title' => null]);
    }

    public function test_quiz_can_has_many_questions()
    {
        $quiz = Quiz::factory()->create();
        $questions = Question::factory()->count(4)->create([
            'quiz_id' => $quiz->id
        ]);

        $this->assertEquals(count($questions), 4);
    }

    public function test_authenticated_user_cannot_view_quizzes_of_others()
    {
        $quiz = Quiz::factory()->create();
        $this->signIn();
        $this->get("/quizzes/{$quiz->id}")->assertForbidden();
    }

    public function test_authenticated_user_cannot_modify_quizzes_of_others()
    {
        $quiz = Quiz::factory()->create();
        $this->signIn();
        $this->patch("/quizzes/{$quiz->id}", ['title' => 'Changed'])->assertForbidden();
    }

    public function test_authenticated_user_cannot_delete_quizzes_of_others()
    {
        $quiz = Quiz::factory()->create();
        $this->signIn();
        $this->delete("/quizzes/{$quiz->id}")->assertForbidden();
    }

    public function test_guest_cannot_manage_quizzes()
    {
        $quiz = Quiz::factory()->create();

        $this->get('/quizzes')->assertRedirect('login');
        $this->get('/quizzes/create')->assertRedirect('login');
        $this->get('/quizzes/edit')->assertRedirect('login');
        $this->get("/quizzes/{$quiz->id}")->assertRedirect('login');
        $this->post('/quizzes', $quiz->toArray())->assertRedirect('login');
    }
}
