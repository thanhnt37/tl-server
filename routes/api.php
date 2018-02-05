<?php

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        Route::group(['middleware' => []], function () {
            // Authentication
            Route::post('signin', 'AuthController@signIn');
//            Route::post('signup', 'AuthController@signUp');
//            Route::post('token/refresh', 'AuthController@refreshToken');
            
            Route::post('activateDevice', 'BoxController@activateDevice');
        });

        Route::group(['middleware' => 'api.client'], function () {
            Route::resource('articles', 'ArticleController');

            Route::post('updateOTA', 'OTAController@updateOTA');
            Route::get('album/lists', 'AlbumController@lists');
            Route::get('album/detail/{id}', 'AlbumController@detail');
            Route::get('song/all', 'SongController@all');
            Route::get('song/detail/{id}', 'SongController@detail');

            Route::post('signout', 'AuthController@postSignOut');

            Route::get('categories/all', 'CategoryController@lists');

            Route::get('store-application/{id}', 'StoreApplicationController@getAppInfo');
        });
    });
});
