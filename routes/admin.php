<?php

\Route::group(['prefix' => 'admin', 'middleware' => ['admin.values']], function () {

    \Route::group(['middleware' => ['admin.guest']], function () {
        \Route::get('signin', 'Admin\AuthController@getSignIn');
        \Route::post('signin', 'Admin\AuthController@postSignIn');
        \Route::get('forgot-password', 'Admin\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'Admin\PasswordController@postForgotPassword');
        \Route::get('reset-password/{token}', 'Admin\PasswordController@getResetPassword');
        \Route::post('reset-password', 'Admin\PasswordController@postResetPassword');
    });

    \Route::group(['middleware' => ['admin.auth']], function () {

        \Route::group(['middleware' => ['admin.has_role.super_user']], function () {
            \Route::resource('boxes', 'Admin\BoxController');
            \Route::resource('kara-versions', 'Admin\KaraVersionController');
            \Route::resource('kara-ota', 'Admin\KaraOtaController');

            \Route::resource('admin-users', 'Admin\AdminUserController');
            \Route::resource('admin-user-notifications', 'Admin\AdminUserNotificationController');
            \Route::resource('oauth-clients', 'Admin\OauthClientController');
            \Route::resource('logs', 'Admin\LogController');

        });

        \Route::group(['middleware' => ['admin.has_role.admin']], function () {
            
            \Route::get('load-notification/{offset}', 'Admin\AdminUserNotificationController@loadNotification');

            \Route::resource('os-versions', 'Admin\OsVersionController');
            \Route::resource('sdk-versions', 'Admin\SdkVersionController');
            \Route::resource('box-versions', 'Admin\BoxVersionController');

            \Route::resource('songs', 'Admin\SongController');
            \Route::resource('albums', 'Admin\AlbumController');
            \Route::get('album-songs/{album_id}/{song_id}', 'Admin\AlbumController@deleteSong');
            \Route::post('album-songs/{album_id}', 'Admin\AlbumController@addNewSong');
            \Route::resource('authors', 'Admin\AuthorController');
        });

        \Route::get('/', 'Admin\IndexController@index');

        \Route::get('/me', 'Admin\MeController@index');
        \Route::put('/me', 'Admin\MeController@update');
        \Route::get('/me/notifications', 'Admin\MeController@notifications');

        \Route::post('signout', 'Admin\AuthController@postSignOut');

        /* NEW ADMIN RESOURCE ROUTE */

    });
});
