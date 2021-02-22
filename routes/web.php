<?php

use App\Http\Controllers\PdfController;
use App\Models\Pdf;
use Illuminate\Support\Facades\Route;

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

Route::prefix('pdf')->group(function () {
    Route::get('/list', [PdfController::class, 'getMainPagePdfList']);
    Route::post('/upload', [PdfController::class, 'upload']);
    Route::get('/get', function (){
        $pdfController = new PdfController();
        $pdfController->getPdfById();
    });
});
