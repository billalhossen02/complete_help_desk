<?php

use Cinebaz\SupportTicket\Http\Controllers\TicketController;
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

$namespace = 'Cinebaz\SupportTicket\Http\Controllers';

Route::namespace($namespace)->prefix('admin')->name('admin.support.')->middleware(['web', 'auth:web'])->group(function () {


Route::get('all/ticket', [TicketController::class, 'adminTicket'])->name('template');
Route::get('edit/ticket/',[TicketController::class, 'editTicket'])->name('show');
Route::post('update/ticket/',[TicketController::class, 'updateTicket'])->name('update');
Route::delete('delete/{id}',[TicketController::class, 'deleteTicket'])->name('delete');
Route::get('admin/reply',[TicketController::class, 'adminReply'])->name('reply');
Route::post('reply/',[TicketController::class,'reply'])->name('reply.msg');


});


