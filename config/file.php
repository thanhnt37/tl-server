<?php

return [
    'acceptable' => [
        'file'  => [
            'application/pdf'                         => 'pdf',
            'application/octet-stream'                => '',
            'application/zip'                         => 'zip',
            'text/plain'                              => 'txt',
            'application/vnd.android.package-archive' => 'apk',
        ],
        'image' => [
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
        ],
    ],
    'categories' => [
        'article_cover_image'    => [
            'name'        => 'article_cover_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [600, 400],
            'thumbnails'  => [
                [400, 300],
                [800, 600],
                [640, 640],  // Instagram
                [735, 1102], // Pinterest
                [1024, 512], // Twitter Card
                [1280, 628], // Facebook OGP
                [1440, 900],
            ],
            'seed_prefix' => 'article_cover',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/articles/'
        ],
        'article_image'          => [
            'name'        => 'article_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [1440, 0],
            'thumbnails'  => [
                [400, 300],
            ],
            'seed_prefix' => 'article',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/articles/'
        ],
        'user_profile_image'     => [
            'name'        => 'user_profile_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [500, 500],
            'thumbnails'  => [
                [100, 100],
                [200, 200]
            ],
            'seed_prefix' => 'user_profile',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/users/'
        ],
        'ogp_image'              => [
            'name'        => 'ogp_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [1280, 628],
            'thumbnails'  => [
            ],
            'seed_prefix' => 'ogp',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/ogp/'
        ],
        'twitter_card_image'     => [
            'name'        => 'twitter_card_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [1024, 512],
            'thumbnails'  => [
            ],
            'seed_prefix' => 'twitter_card',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/ogp/'
        ],
        'kara_apk'               => [
            'name'        => 'kara_apk',
            'type'        => 'file',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'seed_prefix' => 'kara_apk',
            'format'      => 'apk',
            'local_type'  => 'common',
            'local_path'  => 'apk/'
        ],
        'song_cover_image'       => [
            'name'        => 'song_cover_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [640, 480],
            'thumbnails'  => [],
            'seed_prefix' => 'songs',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/songs/'
        ],
        'album_cover_image'      => [
            'name'        => 'album_cover_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [640, 480],
            'thumbnails'  => [],
            'seed_prefix' => 'album_cover_image',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/albums/'
        ],
        'album_background_image' => [
            'name'        => 'album_background_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [640, 480],
            'thumbnails'  => [],
            'seed_prefix' => 'album_background_image',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/albums/'
        ],
        'singer_cover_image'       => [
            'name'        => 'singer_cover_image',
            'type'        => 'image',
            'region'      => env('AWS_IMAGE_REGION'),
            'buckets'     => [
                env('AWS_IMAGE_BUCKET'),
            ],
            'size'        => [640, 480],
            'thumbnails'  => [],
            'seed_prefix' => 'singer_cover_image',
            'format'      => 'png',
            'local_type'  => 'common',
            'local_path'  => 'img/singers/'
        ],
    ],
];
