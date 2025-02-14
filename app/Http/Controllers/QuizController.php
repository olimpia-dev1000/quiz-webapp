<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Termwind\render;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Auth::user()->quizzes;
        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };

        return view('quizzes.show');
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function store()
    {
        $attributes = request()->validate(['title' => 'required|min:3', 'description' => 'required', 'time_limit' => '']);

        Auth::user()->quizzes()->create($attributes);

        return redirect(route('quizzes'));
    }

    public function edit(Quiz $quiz)
    {

        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };


        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Quiz $quiz)
    {
        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };

        $attr = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:100',
            'time_limit' => ''

        ]);

        $quiz->update($attr);

        return redirect(route('quizzes'));
    }

    public function destroy(Quiz $quiz)
    {
        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };

        $quiz->delete();

        return redirect(route('quizzes'));
    }
}
