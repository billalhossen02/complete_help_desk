<?php

use Cinebaz\SupportTicket\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


$namespace = 'BILLAL\SUPPORTTICKET\Http\Controllers';

Route::prefix('{lang?}')->group(function () use ($namespace) {


Route::namespace($namespace)->name('member.auth.')->middleware(['web'])->group(function () {
    
Route::get('ticket',[TicketController::class, 'ticket'])->name('template');
Route::post('ticket/store',[TicketController::class, 'storeData'])->name('store.ticket');
Route::get('MyTicket',[TicketController::class, 'myTicket'])->name('myticket');
Route::get('Reply/Blade/', [TicketController::class, 'replyBlade'])->name('reply.template');
Route::post('user/reply/',[TicketController::class,'userReply'])->name('user.reply');
Route::post('rating/',[TicketController::class, 'rating'])->name('rating');
Route::post('update/status/',[TicketController::class, 'updateStatus'])->name('ticket.status');


 });

});
