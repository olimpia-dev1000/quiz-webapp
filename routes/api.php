<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\App;

Route::post('/cypress/create-user', function (Request $request) {
    if (App::environment('local', 'testing')) {
        $userController = app(RegisteredUserController::class);

        return $userController->store($request);
    }

    return response()->json(['message' => 'Not Found'], 404);
})->middleware('api');
