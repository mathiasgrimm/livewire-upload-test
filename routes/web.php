<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Test1;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return view('welcome');
})->name('home');

Route::get('/test1', Test1::class);

Route::get('/test2', function () {
    $number = ((int) session()->get('number')) + 1;
    session()->put('number', $number);
    return [
        'number' => $number,
        'host' => gethostname(),
    ];
});

Route::get('/testlocale1', function () {
    return "ÅÄÖ and åäö|ÅÄÖ and åäö";
});

Route::get('/testlocale2', function () {
    echo "ÅÄÖ and åäö|ÅÄÖ and åäö";
});

Route::get('/testlocale3', function () {
    return ['messageÅÄÖ and åäö|ÅÄÖ and åäö' => "ÅÄÖ and åäö|ÅÄÖ and åäö"];
});

Route::get('/testhandlerstats', function () {
    $response = Http::withOptions([
        'force_ip_resolve' => 'v4',
    ])->get('https://google.com');
    $log = json_encode($response->handlerStats());
    logger("handlerStatus: {$log}");
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
