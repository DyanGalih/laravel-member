<?php

Route::group(['middleware' => 'web'], function () {
    Route::group(['domain' => env('MY_DASHBOARD', '127.0.0.1')], function () {
        Route::prefix('admin')->group(function () {
            Route::group(['middleware' => ['auth', 'role:admin']], function () {
                Route::name('lazy.')->group(function () {
                    Route::name('identitytype.')->prefix('identitytype')->group(function () {
                        Route::get('', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeIndexController::class)->name('index');
                        Route::get('/{id}', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeDetailController::class)->name('detail');
                        Route::get('/{id}/delete', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeDeleteController::class)->name('delete');
                        Route::post('', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeStoreController::class)->name('post');
                        Route::post('/{id}/update', WebAppId\Member\Controllers\IdentityTypes\IdentityTypeUpdateController::class)->name('update');
                    });

                    Route::name('member.')->prefix('member')->group(function(){
                        Route::get('', WebAppId\Member\Controllers\Members\MemberIndexController::class)->name('index');
                        Route::get('/{id}', WebAppId\Member\Controllers\Members\MemberDetailController::class)->name('detail');
                        Route::get('/{id}/delete', WebAppId\Member\Controllers\Members\MemberDeleteController::class)->name('delete');
                        Route::post('', WebAppId\Member\Controllers\Members\MemberStoreController::class)->name('post');
                        Route::post('/{id}/update', WebAppId\Member\Controllers\Members\MemberUpdateController::class)->name('update');
                    });

                    Route::name('memberaddress.')->prefix('memberaddress')->group(function(){
                        Route::get('', WebAppId\Member\Controllers\MemberAddresses\MemberAddressIndexController::class)->name('index');
                        Route::get('/{id}', WebAppId\Member\Controllers\MemberAddresses\MemberAddressDetailController::class)->name('detail');
                        Route::get('/{id}/delete', WebAppId\Member\Controllers\MemberAddresses\MemberAddressDeleteController::class)->name('delete');
                        Route::post('', WebAppId\Member\Controllers\MemberAddresses\MemberAddressStoreController::class)->name('post');
                        Route::post('/{id}/update', WebAppId\Member\Controllers\MemberAddresses\MemberAddressUpdateController::class)->name('update');
                    });
                });
            });
        });
    });
});