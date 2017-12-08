<?php namespace App\Repositories\Eloquent;

use \App\Repositories\AlbumSongRepositoryInterface;
use \App\Models\AlbumSong;

class AlbumSongRepository extends RelationModelRepository implements AlbumSongRepositoryInterface
{
    /**
     * @var string
     */
    protected $parentKey = '';

    /**
     * @var string
     */
    protected $childKey = '';

    public function getBlankModel()
    {
        return new AlbumSong();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
