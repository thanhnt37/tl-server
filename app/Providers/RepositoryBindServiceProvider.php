<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryBindServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     */
    public function boot() {
        //
    }

    /**
     * Register any application services.
     */
    public function register() {
        $this->app->singleton(
            \App\Repositories\AdminUserRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\AdminUserRoleRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserRoleRepository::class
        );
        $this->app->singleton(
            \App\Repositories\UserRepositoryInterface::class,
            \App\Repositories\Eloquent\UserRepository::class
        );
        $this->app->singleton(
            \App\Repositories\FileRepositoryInterface::class,
            \App\Repositories\Eloquent\FileRepository::class
        );
        $this->app->singleton(
            \App\Repositories\ImageRepositoryInterface::class,
            \App\Repositories\Eloquent\ImageRepository::class
        );
        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\UserServiceAuthenticationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserServiceAuthenticationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\PasswordResettableRepositoryInterface::class,
            \App\Repositories\Eloquent\PasswordResettableRepository::class
        );
        $this->app->singleton(
            \App\Repositories\UserPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\UserPasswordResetRepository::class
        );
        $this->app->singleton(
            \App\Repositories\AdminPasswordResetRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminPasswordResetRepository::class
        );
        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\SiteConfigurationRepositoryInterface::class,
            \App\Repositories\Eloquent\SiteConfigurationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\ArticleRepositoryInterface::class,
            \App\Repositories\Eloquent\ArticleRepository::class
        );
        $this->app->singleton(
            \App\Repositories\NotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\NotificationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\UserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\UserNotificationRepository::class
        );
        $this->app->singleton(
            \App\Repositories\AdminUserNotificationRepositoryInterface::class,
            \App\Repositories\Eloquent\AdminUserNotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\LogRepositoryInterface::class,
            \App\Repositories\Eloquent\LogRepository::class
        );

        $this->app->singleton(
            \App\Repositories\OauthClientRepositoryInterface::class,
            \App\Repositories\Eloquent\OauthClientRepository::class
        );

        $this->app->singleton(
            \App\Repositories\OauthAccessTokenRepositoryInterface::class,
            \App\Repositories\Eloquent\OauthAccessTokenRepository::class
        );

        $this->app->singleton(
            \App\Repositories\OauthRefreshTokenRepositoryInterface::class,
            \App\Repositories\Eloquent\OauthRefreshTokenRepository::class
        );
        $this->app->singleton(
            \App\Repositories\BoxRepositoryInterface::class,
            \App\Repositories\Eloquent\BoxRepository::class
        );

        $this->app->singleton(
            \App\Repositories\KaraVersionRepositoryInterface::class,
            \App\Repositories\Eloquent\KaraVersionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\KaraOtaRepositoryInterface::class,
            \App\Repositories\Eloquent\KaraOtaRepository::class
        );

        $this->app->singleton(
            \App\Repositories\OsVersionRepositoryInterface::class,
            \App\Repositories\Eloquent\OsVersionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SdkVersionRepositoryInterface::class,
            \App\Repositories\Eloquent\SdkVersionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\BoxVersionRepositoryInterface::class,
            \App\Repositories\Eloquent\BoxVersionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AlbumRepositoryInterface::class,
            \App\Repositories\Eloquent\AlbumRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SongRepositoryInterface::class,
            \App\Repositories\Eloquent\SongRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AuthorRepositoryInterface::class,
            \App\Repositories\Eloquent\AuthorRepository::class
        );

        $this->app->singleton(
            \App\Repositories\AlbumSongRepositoryInterface::class,
            \App\Repositories\Eloquent\AlbumSongRepository::class
        );

        $this->app->singleton(
            \App\Repositories\GenreRepositoryInterface::class,
            \App\Repositories\Eloquent\GenreRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SingerRepositoryInterface::class,
            \App\Repositories\Eloquent\SingerRepository::class
        );

        $this->app->singleton(
            \App\Repositories\GenreSongRepositoryInterface::class,
            \App\Repositories\Eloquent\GenreSongRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SingerSongRepositoryInterface::class,
            \App\Repositories\Eloquent\SingerSongRepository::class
        );

        $this->app->singleton(
            \App\Repositories\CustomerRepositoryInterface::class,
            \App\Repositories\Eloquent\CustomerRepository::class
        );

        $this->app->singleton(
            \App\Repositories\SaleRepositoryInterface::class,
            \App\Repositories\Eloquent\SaleRepository::class
        );

        $this->app->singleton(
            \App\Repositories\ApplicationRepositoryInterface::class,
            \App\Repositories\Eloquent\ApplicationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\DeveloperRepositoryInterface::class,
            \App\Repositories\Eloquent\DeveloperRepository::class
        );

        $this->app->singleton(
            \App\Repositories\StoreApplicationRepositoryInterface::class,
            \App\Repositories\Eloquent\StoreApplicationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\CategoryRepositoryInterface::class,
            \App\Repositories\Eloquent\CategoryRepository::class
        );

        /* NEW BINDING */
    }
}
