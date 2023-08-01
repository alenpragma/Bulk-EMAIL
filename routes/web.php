<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InsertLeadsController;
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
Route::get('/',[HomeController::class,'showLogin'])->name('show_login');

Route::post('/register',[HomeController::class,'register'])->name('register');
Route::post('/login',[HomeController::class,'login'])->name('login');
    Route::group(['middleware'=>'is_login'], function(){
        
        Route::get('/logout',[HomeController::class,'logout'])->name('logout');
        Route::get('/dashboard',[HomeController::class,'index'])->name('home');
        Route::get('/create/insertleads',[HomeController::class,'insertLeadShow'])->name('insert_leads.create');
        Route::get('/create/regular/smtp',[HomeController::class,'regularSmtpShow'])->name('regular_smtp.create');
        Route::get('/insertleads',[HomeController::class,'insertLeads'])->name('insert_leads');
        Route::get('/mail_send',[HomeController::class,'mailSend'])->name('mail_send');
        Route::get('/regular/smtp',[HomeController::class,'regularSmtp'])->name('regular_smtp');
        Route::get('/deleteOldImage/{id}',[HomeController::class,'deleteOldImage'])->name('deleteOldImage');
        Route::post('/sentsmtp',[HomeController::class,'sentsmtp'])->name('sentsmtp');
        Route::get('/smtpdownload',[HomeController::class,'smtpdownload'])->name('smtpdownload');
        Route::post('/smtpimport',[HomeController::class,'smtpimport'])->name('smtpimport');



        Route::post('/insertleads',[InsertLeadsController::class,'insertLeadStore'])->name('insert_lead.store');
        Route::post('/regular_smtp',[InsertLeadsController::class,'regularSmtpStore'])->name('regular_smtp.store');
        Route::get('/smtp/delete/{id}',[InsertLeadsController::class,'deleteSmtp'])->name('smtp.delete');
        Route::get('/deleteallSmtp',[InsertLeadsController::class,'deleteallSmtp'])->name('deleteallSmtp');
        Route::get('/smtp/edit/{id}',[InsertLeadsController::class,'editSmtp'])->name('smtp.edit');
        Route::post('/smtp/update/{id}',[InsertLeadsController::class,'updateSmtp'])->name('smtp.update');
       Route::get('/smtp/testSmtp/{id}',[InsertLeadsController::class,'testSmtp'])->name('smtp.testSmtp');
       Route::get('/users',[InsertLeadsController::class,'users'])->name('users');
       Route::get('/user_make',[InsertLeadsController::class,'user_make'])->name('user_make');
       Route::post('/user_post',[InsertLeadsController::class,'user_post'])->name('user_post');
       Route::get('/user_edit/{id}',[InsertLeadsController::class,'user_edit'])->name('user_edit');
       Route::post('/user_edit_post/{id}',[InsertLeadsController::class,'user_edit_post'])->name('user_edit_post');
       Route::get('/delete_user/{id}',[InsertLeadsController::class,'delete_user'])->name('delete_user');
       Route::get('/limitupdate',[InsertLeadsController::class,'limitupdate'])->name('limitupdate')->middleware(1);
       Route::get('Campaign_Name',[InsertLeadsController::class,'Campaign_Name'])->name('Campaign_Name');
       Route::get('ReplyTo',[InsertLeadsController::class,'ReplyTo'])->name('ReplyTo');
       Route::post('Campaign_Name_update/{id}',[InsertLeadsController::class,'Campaign_Name_update'])->name('Campaign_Name_update');
       Route::post('ReplyTo_update/{id}',[InsertLeadsController::class,'ReplyTo_update'])->name('ReplyTo_update');
       Route::post('/updateLimit', [InsertLeadsController::class, 'updateLimit'])->name('updateLimit');

        Route::get('/mail/send',[InsertLeadsController::class,'mailSend'])->name('mail.send');

        Route::get('/mail/delete/{id}',[InsertLeadsController::class,'deleteMail'])->name('mail.delete');
        Route::get('/mail_all/delete',[InsertLeadsController::class,'deleteAllMail'])->name('mail_all.delete');

        Route::get('status/{id}',[InsertLeadsController::class,'status'])->name('status');
        Route::get('/show/message',[HomeController::class,'message'])->name('message.create');
        Route::post('/message/store/{id}',[InsertLeadsController::class,'messageStore'])->name('message.store');
        
        Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
        Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');
});



Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


Route::get('/clear', function() {

Artisan::call('cache:clear');
Artisan::call('config:cache');
Artisan::call('view:clear');
return "Cleared!";
});


Route::get('reset', function (){
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
});