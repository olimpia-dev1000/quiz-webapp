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
        return view('quizzes.index');
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
        $attributes = request()->validate(['title' => 'required', 'description' => 'required']);

        Auth::user()->quizzes()->create($attributes);

        return redirect('/');
    }

    public function update(Quiz $quiz)
    {
        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };

        $attr = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:100'
        ]);

        $quiz->update($attr);

        return redirect('/');
    }

    public function destroy(Quiz $quiz)
    {
        if (Auth::user()->id != $quiz->owner->id) {
            abort(403);
        };

        $quiz->delete();

        return redirect('/');
    }
}
