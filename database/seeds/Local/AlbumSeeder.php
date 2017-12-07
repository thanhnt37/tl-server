<?php

namespace Seeds\Local;

use App\Models\Album;
use App\Models\AlbumSong;
use App\Models\Author;
use App\Models\Genre;
use App\Models\GenreSong;
use App\Models\Singer;
use App\Models\SingerSong;
use App\Models\Song;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 30, 1) as $authors) {
            factory(Author::class)->create();
        }
        foreach(range(1, 100, 1) as $songs) {
            factory(Song::class)->create(
                [
                    'author_id' => rand(1, 30)
                ]
            );
        }

        foreach(range(1, 30, 1) as $albums) {
            $album = factory(Album::class)->create();

            foreach(range(7, 20, 1) as $count) {
                factory(AlbumSong::class)->create(
                    [
                        'album_id' => $album->id,
                        'song_id'  => rand(1, 100),
                    ]
                );
            }
        }
        foreach(range(1, 30, 1) as $singers) {
            $singer = factory(Singer::class)->create();

            foreach(range(10, 30, 1) as $count) {
                factory(SingerSong::class)->create(
                    [
                        'singer_id' => $singer->id,
                        'song_id'  => rand(1, 100),
                    ]
                );
            }
        }
        foreach(range(1, 30, 1) as $genres) {
            $genre = factory(Genre::class)->create();

            foreach(range(10, 30, 1) as $count) {
                factory(GenreSong::class)->create(
                    [
                        'genre_id' => $genre->id,
                        'song_id'  => rand(1, 100),
                    ]
                );
            }
        }
        foreach(range(1, 30, 1) as $topics) {
            factory(Topic::class)->create();
        }
    }
}
