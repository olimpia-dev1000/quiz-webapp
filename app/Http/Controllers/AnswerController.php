<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function create(Quiz $quiz, Question $question)
    {
        if ($question->quiz_id !== $quiz->id) {
            abort(404);
        }

        $answers = $question->answers;

        $answersReachedLimit = ($answers->count() >= 4) ? true : false;

        $hasCorrectAnswer = $answers->contains('is_correct', true);

        return view('answers.create', compact('quiz', 'question', 'answers', 'answersReachedLimit', 'hasCorrectAnswer'));
    }

    public function store(Quiz $quiz, Question $question)
    {
        $answerCount = $question->answers()->count();

        if ($answerCount >= 4) {
            throw new \Exception('You can only have a maximum of 4 answers per question.');
        }

        if ($question->question_type === 'true_false' && $answerCount >= 2) {
            throw new \Exception('You can only have a maximum of 2 answers for a true/false question.');
        }

        $attributes = request()->validate([
            'answer_text' => 'required',
            'is_correct' => 'nullable|boolean'
        ]);

        $attributes['is_correct'] = request()->has('is_correct') ? true : false;

        $question->answers()->create($attributes);

        return redirect(route('answers.create', ['quiz' => $quiz->id, 'question' => $question->id]));
    }

    public function edit(Quiz $quiz, Question $question, Answer $answer)
    {
        return view('answers.edit', compact('quiz', 'question'));
    }

    public function update(Quiz $quiz, Question $question, Answer $answer)
    {
        $attributes = request()->validate([
            'answer_text' => 'required|sometimes',
            'is_correct' => 'required|sometimes'
        ]);

        $attributes['is_correct'] = request()->has('is_correct') ? true : false;

        $answer->update($attributes);

        return redirect(route('answers', ['quiz' => $quiz->id, 'question' => $question->id]));
    }

    public function destroy(Quiz $quiz, Question $question, Answer $answer)
    {
        $answer->delete();

        return redirect(route('answers', ['quiz' => $quiz->id, 'question' => $question->id]));
    }
}
