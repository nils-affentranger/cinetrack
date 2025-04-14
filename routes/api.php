<?php

use App\Http\Controllers\AuditoriumController;
use App\Http\Controllers\CinemaChainController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CinemaPriceHistoryController;
use App\Http\Controllers\CinemaTicketTypePriceController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;

// Cinema Chain Routes
Route::apiResource('cinema-chains', CinemaChainController::class);

// Cinema Routes
Route::get('/cinemas/search', [CinemaController::class, 'search']);
Route::get('/cinemas/autocomplete', [CinemaController::class, 'autocomplete']);
Route::apiResource('cinemas', CinemaController::class);

// Auditorium Routes (Nested under Cinemas)
Route::prefix('cinemas/{cinema}/auditoriums')->group(function () {
    Route::get('/', [AuditoriumController::class, 'index']);
    Route::post('/', [AuditoriumController::class, 'store']);
    Route::get('/{auditorium}', [AuditoriumController::class, 'show']);
    Route::put('/{auditorium}', [AuditoriumController::class, 'update']);
    Route::delete('/{auditorium}', [AuditoriumController::class, 'destroy']);
    Route::get('/autocomplete', [AuditoriumController::class, 'autocomplete']);
});

// Movie Routes
Route::get('/movies/search', [MovieController::class, 'search']);
Route::get('/movies/autocomplete', [MovieController::class, 'autocomplete']);
Route::post('/movies/{movie}/upload-poster', [MovieController::class, 'uploadPoster']);
Route::apiResource('movies', MovieController::class);

// Ticket Type Routes
Route::apiResource('ticket-types', TicketTypeController::class);

// Visit Routes
Route::apiResource('visits', VisitController::class);

// Cinema Price History Routes
Route::apiResource('cinema-price-history', CinemaPriceHistoryController::class);

// Cinema Ticket Type Price Routes
Route::apiResource('cinema-ticket-type-prices', CinemaTicketTypePriceController::class);

// Route binding
Route::bind('cinema', function ($value) {
    return App\Models\Cinema::where('id', $value)->first() ?? abort(404);
});

Route::bind('auditorium', function ($value) {
    return App\Models\Auditorium::where('id', $value)->first() ?? abort(404);
});

Route::bind('movie', function ($value) {
    return App\Models\Movie::where('id', $value)->first() ?? abort(404);
});

Route::bind('cinemaPriceHistory', function ($value) {
    return App\Models\CinemaPriceHistory::where('id', $value)->first() ?? abort(404);
});

Route::bind('ticketType', function ($value) {
    return App\Models\TicketType::where('id', $value)->first() ?? abort(404);
});

Route::bind('visit', function ($value) {
    return App\Models\Visit::where('id', $value)->first() ?? abort(404);
});

Route::bind('cinemaChain', function ($value) {
    return App\Models\CinemaChain::where('id', $value)->first() ?? abort(404);
});

Route::bind('cinemaTicketTypePrice', function ($value) {
    return App\Models\CinemaTicketTypePrice::where('id', $value)->first() ?? abort(404);
});
