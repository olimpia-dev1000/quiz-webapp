<?php

namespace App\Http\Controllers;


use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Termwind\render;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        return view('questions.index', ['quiz' => $quiz, 'questions' => $quiz->questions]);
    }

    public function store(Quiz $quiz)
    {
        if (Auth::id() !== ($quiz->owner_id)) {
            abort(403);
        };

        $attributes = request()->validate([
            'question_text' => 'required',
            'question_type' => 'sometimes|required',
            'points' => 'sometimes|required',
            'order_number' => 'sometimes|required',
        ]);


        $quiz->questions()->create($attributes);
        return redirect("/quizzes/{$quiz->id}/questions");
    }
    public function update(Quiz $quiz, Question $question)
    {

        if (Auth::id() !== ($quiz->owner_id)) {
            abort(403);
        };

        $attributes = request()->validate([
            'question_text' => 'sometimes|required',
            'question_type' => 'sometimes|required',
            'points' => 'sometimes|required',
            'order_number' => 'sometimes|required',
        ]);


        $question->update($attributes);

        return redirect("/quizzes/{$quiz->id}/questions");
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        if (Auth::id() !== ($quiz->owner_id)) {
            abort(403);
        }

        $question->delete();

        return redirect("/quizzes/{$quiz->id}/questions");
    }
    public function reorder(Request $request, $quizId)
    {
        $questions = $request->input('questions');

        foreach ($questions as $question) {
            Question::where('id', $question['id'])->update(['order_number' => $question['order_number']]);
        }


        return  response()->json(['success' => true]);
    }
}
