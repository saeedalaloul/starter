<?php
Route::get('/admin',function (){
   return "admin";
});

Route::namespace('Front')->group(function(){
    Route::get('users','UserController@showAdminName');
});

Route::resource('news','NewsController');
