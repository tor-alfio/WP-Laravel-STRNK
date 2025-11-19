<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\PasswordResetController;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::get('/allenamenti', [WorkoutController::class, 'allenamenti'])
    ->middleware('auth')
    ->name('allenamenti');

Route::get('/allenamentiHome', [WorkoutController::class, 'allenamentiHome'])
    ->middleware('auth')
    ->name('allenamentiHome');

Route::get('/programmazione', [WorkoutController::class, 'programmazione'])
    ->middleware('auth')
    ->name('programmazione');

Route::middleware('auth')->get('/users', [UserController::class, 'usersView'])->name('users');

Route::middleware('auth')->get('/api/get-Users', [UserController::class, 'getUsers']);

Route::get('/callback', [SpotifyController::class, 'callback']);

Route::get('/password/forgot', [\App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('password.forgot');

Route::post('/password/forgot', [\App\Http\Controllers\PasswordResetController::class, 'generateResetLink'])->name('password.generate');

Route::get('/password/reset/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');

Route::post('/password/reset', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');


Route::middleware('auth')->prefix('api')->group(function () {
    Route::post('/get-Training', [WorkoutController::class, 'getTraining']);
    Route::post('/add-Workout', [WorkoutController::class, 'addWorkout']);
    Route::post('/delete-Workout', [WorkoutController::class, 'deleteWorkout']);

    Route::get('/get-Exercises', [ExerciseController::class, 'getExercises']);
    Route::post('/show-Exercises', [ExerciseController::class, 'showExercises']);
    Route::post('/add-Exercise', [ExerciseController::class, 'addExercise']);

    Route::get('/get-Users', [UserController::class, 'getUsers']);
    Route::post('/send-Workout', [UserController::class, 'sendWorkout']);

    Route::post('/check-Friendship', [FriendshipController::class, 'checkFriendship']);
    Route::post('/send-Friendship', [FriendshipController::class, 'sendFriendship']);
    Route::post('/accept-Friendship', [FriendshipController::class, 'acceptFriendship']);

    Route::get('/get-Notifications', [NotificationController::class, 'getNotifications']);
});

