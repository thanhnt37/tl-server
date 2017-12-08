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

            \Route::resource('authors', 'Admin\AuthorController');
            \Route::resource('songs', 'Admin\SongController');
            \Route::post('song-albums/{song_id}', 'Admin\SongController@addNewAlbum');
            \Route::post('song-genres/{song_id}', 'Admin\SongController@addNewGenre');
            \Route::post('song-singers/{song_id}', 'Admin\SongController@addNewSinger');


            \Route::resource('singers', 'Admin\SingerController');
            \Route::get('singer-songs/{singer_id}/{song_id}', 'Admin\SingerController@deleteSong');
            \Route::post('singer-songs/{singer_id}', 'Admin\SingerController@addNewSong');

            \Route::resource('albums', 'Admin\AlbumController');
            \Route::get('album-songs/{album_id}/{song_id}', 'Admin\AlbumController@deleteSong');
            \Route::post('album-songs/{album_id}', 'Admin\AlbumController@addNewSong');

            \Route::resource('genres', 'Admin\GenreController');
            \Route::get('genre-songs/{genre_id}/{song_id}', 'Admin\GenreController@deleteSong');
            \Route::post('genre-songs/{genre_id}', 'Admin\GenreController@addNewSong');
        });

        \Route::get('/', 'Admin\IndexController@index');

        \Route::get('/me', 'Admin\MeController@index');
        \Route::put('/me', 'Admin\MeController@update');
        \Route::get('/me/notifications', 'Admin\MeController@notifications');

        \Route::post('signout', 'Admin\AuthController@postSignOut');

        /* NEW ADMIN RESOURCE ROUTE */

    });
});
