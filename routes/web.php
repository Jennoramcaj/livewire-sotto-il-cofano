<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('livewire', function () {
    $snapshot = request()->get('snapshot');
    $component = (new \App\Livewire)->fromSnapshot($snapshot);

    if ($method = request('callMethod')) {
        (new \App\Livewire)->callMethod($component, $method);
    }

    [$html, $snapshot] = (new \App\Livewire)->toSnapshot($component);

    return [
        'html' => $html,
        'snapshot' => $snapshot
    ];

});
