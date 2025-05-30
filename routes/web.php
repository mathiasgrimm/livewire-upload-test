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
    $services = [];
    $databaseIps = gethostbynamel(config('database')['connections'][config('database.default')]['host']);

    foreach ($databaseIps as $databaseIp) {
        $services[] = [
            'host' => $databaseIp,
            'port' => config('database')['connections'][config('database.default')]['port'],
            'latency' => [],
        ];
    }

    $redisIps = gethostbynamel(str_replace('tls://', '', config('database')['redis']['default']['host']));
    foreach ($redisIps as $redisIp) {
        $services[] = [
            'host' => $redisIp,
            'port' => config('database')['redis']['default']['port'],
            'latency' => [],
        ];
    }

    foreach ($services as &$service) {
        for ($i = 0; $i < 10; $i++) {
            $t0 = microtime(true);
            $fp = @fsockopen($service['host'], $service['port'], $errno, $errstr, 5);
            $t1 = microtime(true);
            if ($fp) {
                @fclose($fp);
            }

            $service['latency'][] = ($t1 - $t0) * 1000;
        }

        $service['latency']['avg'] = array_sum($service['latency']) / count($service['latency']);
    }

    return "<pre>" . json_encode($services, JSON_PRETTY_PRINT);
});

Route::get('/testlatency2', function () {
    $latency = [];
    for ($i = 0; $i < 10; $i++) {
        $t0 = microtime(true);
        DB::unprepared('select 1');
        $t1 = microtime(true);
        $latency[] = ($t1 - $t0) * 1000;
    }

    $latency['avg'] = array_sum($latency) / count($latency);

    return "<pre>" . json_encode($latency, JSON_PRETTY_PRINT);
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
