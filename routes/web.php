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

Route::get('/test3', function () {
    return [
        'ip' => request()->ip(),
        'ips' => request()->ips(),
    ];
});

Route::get('/testlatency', function () {
    $services = [
        'database' => [
            'host' => config('database')['connections'][config('database.default')]['host'],
            'port' => config('database')['connections'][config('database.default')]['port'],
            'latency' => [],
        ],

        'redis' => [
            'host' => config('database')['redis']['default']['host'],
            'port' => config('database')['redis']['default']['port'],
            'latency' => [],
        ],
    ];


    foreach ($services as &$service) {
        $fp = @fsockopen($service['host'], $service['port'], $errno, $errstr, 5);

        for ($i = 0; $i < 10; $i++) {
            $t0 = microtime(true);
            if (@fwrite($fp, '') === false) {
                continue 2;
            };
            $t1 = microtime(true);


            $service['latency'][] = ($t1 - $t0) * 1000;
        }

        if ($fp) {
            @fclose($fp);
        }

        $service['latency']['avg'] = array_sum($service['latency']) / count($service['latency']);
    }

    return "<pre>" . json_encode($services, JSON_PRETTY_PRINT);
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
