<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(
    App\Models\User::class,
    function (Faker\Generator $faker)
    {
        return [
            'name'                 => $faker->name,
            'email'                => $faker->email,
            'password'             => bcrypt(str_random(10)),
            'remember_token'       => str_random(10),
            'gender'               => 1,
            'telephone'            => $faker->phoneNumber,
            'birthday'             => $faker->date('Y-m-d'),
            'locale'               => $faker->languageCode,
            'address'              => $faker->address,
            'last_notification_id' => 0,
            'api_access_token'     => '',
            'profile_image_id'     => 0,
            'is_activated'         => 0,
        ];
    }
);

$factory->define(
    App\Models\AdminUser::class,
    function (Faker\Generator $faker)
    {
        return [
            'name'                 => $faker->name,
            'email'                => $faker->email,
            'password'             => bcrypt(str_random(10)),
            'remember_token'       => str_random(10),
            'locale'               => $faker->languageCode,
            'last_notification_id' => 0,
            'api_access_token'     => '',
            'profile_image_id'     => 0,
        ];
    }
);

$factory->define(
    App\Models\AdminUserRole::class,
    function (Faker\Generator $faker)
    {
        return [
            'admin_user_id' => $faker->randomNumber(),
            'role'          => 'supper_user'
        ];
    }
);

$factory->define(
    App\Models\SiteConfiguration::class,
    function (Faker\Generator $faker)
    {
        return [
            'locale'                => 'ja',
            'name'                  => $faker->name,
            'title'                 => $faker->sentence,
            'keywords'              => implode(',', $faker->words(5)),
            'description'           => $faker->sentences(3, true),
            'ogp_image_id'          => 0,
            'twitter_card_image_id' => 0,
        ];
    }
);

$factory->define(
    App\Models\Image::class,
    function (Faker\Generator $faker)
    {
        return [
            'url'                => $faker->imageUrl(),
            'title'              => $faker->sentence,
            'is_local'           => false,
            'entity_type'        => $faker->word,
            'entity_id'          => 0,
            'file_category_type' => $faker->word,
            's3_key'             => $faker->word,
            's3_bucket'          => $faker->word,
            's3_region'          => $faker->word,
            's3_extension'       => 'png',
            'media_type'         => 'image/png',
            'format'             => 'png',
            'file_size'          => 0,
            'width'              => 100,
            'height'             => 100,
            'is_enabled'         => true,
        ];
    }
);

$factory->define(
    App\Models\Article::class,
    function (Faker\Generator $faker)
    {
        return [
            'slug'               => $faker->word,
            'title'              => $faker->sentence,
            'keywords'           => implode(',', $faker->words(5)),
            'description'        => $faker->sentences(3, true),
            'content'            => $faker->sentences(3, true),
            'cover_image_id'     => 0,
            'locale'             => 'ja',
            'is_enabled'         => true,
            'publish_started_at' => $faker->dateTime,
            'publish_ended_at'   => null,
        ];
    }
);

$factory->define(
    App\Models\UserNotification::class,
    function (Faker\Generator $faker)
    {
        return [
            'user_id'       => \App\Models\UserNotification::BROADCAST_USER_ID,
            'category_type' => \App\Models\UserNotification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            'type'          => \App\Models\UserNotification::TYPE_GENERAL_MESSAGE,
            'data'          => '',
            'locale'        => 'en',
            'content'       => 'TEST',
            'read'          => false,
            'sent_at'       => $faker->dateTime,
        ];
    }
);

$factory->define(
    App\Models\AdminUserNotification::class,
    function (Faker\Generator $faker)
    {
        return [
            'user_id'       => \App\Models\AdminUserNotification::BROADCAST_USER_ID,
            'category_type' => \App\Models\AdminUserNotification::CATEGORY_TYPE_SYSTEM_MESSAGE,
            'type'          => \App\Models\AdminUserNotification::TYPE_GENERAL_MESSAGE,
            'data'          => '',
            'locale'        => 'en',
            'content'       => 'TEST',
            'read'          => false,
            'sent_at'       => $faker->dateTime,
        ];
    }
);

$factory->define(App\Models\Box::class, function (Faker\Generator $faker)
{
    return [
        'imei'            => $faker->unique()->bankAccountNumber,
        'serial'          => $faker->unique()->creditCardNumber,
        'box_version_id'  => 0,
        'os_version_id'   => 0,
        'sdk_version_id'  => 0,
        'is_activated'    => true,
        'is_blocked'      => false,
        'activation_date' => $faker->dateTime,
    ];
});

$factory->define(App\Models\AppVersion::class, function (Faker\Generator $faker)
{
    return [
        'application_id' => 0,
        'version'        => $faker->unique()->regexify("^(\d+\.)?(\d+\.)?(\d+)$"),
        'name'           => $faker->word,
        'description'    => $faker->sentences(5, true),
        'apk_package_id' => 0,
    ];
});

$factory->define(App\Models\AppOta::class, function (Faker\Generator $faker)
{
    return [
        'os_version_id'  => 0,
        'sdk_version_id' => 0,
        'box_version_id' => 0,
        'app_version_id' => 0,
    ];
});

$factory->define(App\Models\OsVersion::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Models\SdkVersion::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Models\BoxVersion::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Models\Song::class, function (Faker\Generator $faker)
{
    return [
        'code'           => $faker->unique()->bankAccountNumber,
        'wildcard'       => $faker->unique()->word,
        'name'           => $faker->sentence,
        'description'    => $faker->sentences(10, true),
        'link'           => $faker->url,
        'type'           => 'mp4',
        'sub_link'       => $faker->url,
        'cover_image_id' => 0,
        'view'           => rand(100, 1000),
        'play'           => rand(50, 500),
        'vote'           => rand(20, 200),
        'author_id'      => 0,
        'publish_at'     => $faker->dateTime,
    ];
});

$factory->define(App\Models\Author::class, function (Faker\Generator $faker)
{
    return [
        'name'        => $faker->name(),
        'description' => $faker->sentences(10, true),
        'image'       => $faker->imageUrl(),
    ];
});

$factory->define(App\Models\Album::class, function (Faker\Generator $faker)
{
    return [
        'name'                => $faker->sentence,
        'description'         => $faker->sentences(10, true),
        'cover_image_id'      => 0,
        'background_image_id' => 0,
        'vote'                => rand(20, 200),
        'publish_at'          => $faker->dateTime,
    ];
});

$factory->define(App\Models\Singer::class, function (Faker\Generator $faker)
{
    return [
        'wildcard'       => $faker->unique()->word,
        'name'           => $faker->name(),
        'description'    => $faker->sentences(10, true),
        'cover_image_id' => 0,
    ];
});

$factory->define(App\Models\Genre::class, function (Faker\Generator $faker)
{
    return [
        'name'        => $faker->word,
        'description' => $faker->sentences(10, true),
        'image'       => $faker->imageUrl(),
    ];
});

$factory->define(App\Models\Topic::class, function (Faker\Generator $faker)
{
    return [
        'name'        => $faker->word,
        'description' => $faker->sentences(10, true),
        'image'       => $faker->imageUrl(),
    ];
});

$factory->define(App\Models\AlbumSong::class, function (Faker\Generator $faker)
{
    return [
        'album_id' => 0,
        'song_id'  => 0,
    ];
});

$factory->define(App\Models\SingerSong::class, function (Faker\Generator $faker)
{
    return [
        'singer_id' => 0,
        'song_id'   => 0,
    ];
});

$factory->define(App\Models\GenreSong::class, function (Faker\Generator $faker)
{
    return [
        'genre_id' => 0,
        'song_id'  => 0,
    ];
});

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker)
{
    return [
        'name'      => $faker->name(),
        'email'     => $faker->email,
        'address'   => $faker->address,
        'telephone' => $faker->phoneNumber,
        'area'      => $faker->address,
        'agency'    => $faker->address,
    ];
});

$factory->define(App\Models\Sale::class, function (Faker\Generator $faker)
{
    return [
        'customer_id' => 0,
        'box_id'      => 0,
    ];
});

$factory->define(App\Models\Application::class, function (Faker\Generator $faker)
{
    return [
        'name'       => $faker->sentence,
        'app_key'    => $faker->md5,
        'is_blocked' => false,
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker)
{
    return [
        'name'           => $faker->sentence,
        'description'    => $faker->sentences(10, true),
        'type'           => 0,
        'cover_image_id' => 0,
    ];
});

$factory->define(App\Models\Developer::class, function (Faker\Generator $faker)
{
    return [
        'name' => $faker->sentence,
    ];
});

$factory->define(App\Models\StoreApplication::class, function (Faker\Generator $faker)
{
    return [
        'name'                => $faker->sentence,
        'version_name'        => $faker->sentence,
        'version_code'        => $faker->postcode,
        'package_name'        => $faker->sentence,
        'description'         => $faker->sentences(10, true),
        'tags'                => $faker->words(10, true),
        'icon_image_id'       => 0,
        'background_image_id' => 0,
        'hit'                 => $faker->randomNumber(),
        'min_sdk'             => 0,
        'apk_package_id'      => 0,
        'category_id'         => 0,
        'developer_id'        => 0,
        'publish_started_at'  => $faker->dateTime(),
    ];
});

/* NEW MODEL FACTORY */
