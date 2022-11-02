<?php

use App\Http\Controllers\ExcelController;
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

Route::get('/', [\App\Http\Controllers\ParserController::class, 'renderForm']);


Route::get('file-import-export', [ExcelController::class, 'fileImportExport']);
Route::post('file-import', [ExcelController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [ExcelController   ::class, 'fileExport'])->name('file-export');
