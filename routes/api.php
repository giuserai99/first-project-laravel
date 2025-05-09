<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\RabbitController;
use Illuminate\Support\Facades\Route;

//Route::post('/test', [RabbitController::class, 'test']);

Route::post('/emails/send', [MailController::class, 'sendMail']);

Route::get('/emails', [MailController::class, 'getAll']);

Route::get('/email/{id}', [MailController::class, 'getMail']);

Route::delete('/email/{id}', [MailController::class, 'deleteMail']);

Route::patch('/email/{id}', [MailController::class, 'updateMail']);