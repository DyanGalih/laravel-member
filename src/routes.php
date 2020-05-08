<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['domain' => env('MY_DASHBOARD', '127.0.0.1')], function (){
        Route::name('lazy.')->group(function(){
            Route::name('identitytype.')->prefix('identitytype')->group(function(){
                Route::get('', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeIndexController::class)->name('index');
                Route::get('/{id}', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeDetailController::class)->name('detail');
                Route::get('/{id}/delete', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeDeleteController::class)->name('delete');
                Route::post('', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeStoreController::class)->name('post');
                Route::post('/{id}/update', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeUpdateController::class)->name('update');
            });
        });
    });
});
