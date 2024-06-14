<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/list-form', [FormController::class, 'index'])->name('list.form');
// Route::get('/create-form', [FormController::class, 'create'])->name('create.form');
Route::post('/save-form', [FormController::class, 'saveFormName'])->name('form.save');
Route::get('/form/{id}/add-attributes', [FormController::class, 'addFormAttributes'])->name('form.add-attributes');
// Route::get('/form/add-attributes/{id}', [FormController::class, 'addFormAttributes'])->name('form.add-attributes');
Route::post('/add-fields', [FormController::class, 'saveFormAttributes'])->name('save.formAttributes');
// Route::get('/form/{id}/edit', [FormController::class, 'editForm'])->name('form.edit');

Route::get('/form/{id}/show', [FormController::class, 'showForm'])->name('form.show');
// Route::get('/test-queue', [FormController::class, 'testQueue'])->name('form.testQueue');
Route::post('/form/submit-form', [FormController::class, 'submitForm'])->name('form.submitForm');
Route::get('/form/{id}/edit-attributes', [FormController::class, 'editFormAttributes'])->name('form.editFormAttribute');
Route::post('/form/update-attributes', [FormController::class, 'updateAttributes'])->name('form.updateAttributes');
Route::get('/form/{id}/delete-attributes', [FormController::class, 'deleteAttributes'])->name('form.deleteAttribute');
