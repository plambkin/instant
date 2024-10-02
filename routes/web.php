<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GardenController;
use App\Http\Controllers\SubmissionController;



use Barryvdh\DomPDF\Facade as PDF;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/test-pdf', function () {
    $pdf = PDF::loadHTML('<h1>Test PDF</h1>');
    return $pdf->download('test.pdf');
});

Route::post('/generate-garden', [GardenController::class, 'generateGarden'])->name('generate.garden');


Route::get('/gardens', [GardenController::class, 'viewGardens'])->name('gardens.view');



Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');


// Define the route for exporting gardens as a PDF
Route::get('/gardens/export/pdf', [GardenController::class, 'exportToPDF'])->name('gardens.export.pdf');


Route::post('/save-gardens', [GardenController::class, 'saveGardens']);


//Route::get('/gardens/export-pdf', [GardenController::class, 'exportToPDF'])->name('gardens.export');



Route::post('/get-garden', [GardenController::class, 'getGarden']);


Route::get('/subscription/upgrade', [SubscriptionController::class, 'showUpgradePage'])->name('subscription.upgrade');


Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');



Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard')->middleware('auth');


Route::get('/submission/{id}', [SubmissionController::class, 'show'])->name('submission.show');

//Route::post('/export-pdf', [SubmissionController::class, 'exportPdf'])->name('export.pdf');






require __DIR__.'/auth.php';
