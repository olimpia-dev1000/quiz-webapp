<?php

namespace Database\Seeders;

use App\Models\User;
use Tests\Setup\QuizFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestQuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $email = env('TEST_USER_EMAIL', 'testuser@example.com');
        $questionsCount = env('TEST_QUESTIONS_COUNT', 5);
        $hasAnswers = env('TEST_HAS_ANSWERS', false);

        // Find the user
        $user = User::where('email', $email)->first();
        if (!$user) {
            echo "User not found!";
            return;
        }

        // Ensure previous quizzes are removed for a clean test
        DB::table('quizzes')->where('owner_id', $user->id)->delete();

        // Create quiz using QuizFactory
        (new QuizFactory())
            ->ownedBy($user)
            ->withQuestions($questionsCount)
            ->withAnswers($hasAnswers)
            ->create();
    }
}
