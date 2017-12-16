<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'wildcard',
        'name',
        'description',
        'link',
        'type',
        'sub_link',
        'image',
        'view',
        'play',
        'vote',
        'author_id',
        'publish_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['publish_at', 'deleted_at'];

    protected $presenter = \App\Presenters\SongPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SongObserver);
    }

    // Relations
    public function author()
    {
        return $this->belongsTo(\App\Models\Author::class, 'author_id', 'id');
    }

    public function albums()
    {
        return $this->belongsToMany(\App\Models\Album::class, AlbumSong::getTableName(), 'song_id', 'album_id');
    }

    public function genres()
    {
        return $this->belongsToMany(\App\Models\Genre::class, GenreSong::getTableName(), 'song_id', 'genre_id');
    }

    public function singers()
    {
        return $this->belongsToMany(\App\Models\Singer::class, SingerSong::getTableName(), 'song_id', 'singer_id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'code'        => $this->code,
            'wildcard'    => $this->wildcard,
            'name'        => $this->name,
            'description' => $this->description,
            'link'        => $this->link,
            'type'        => $this->type,
            'sub_link'    => $this->sub_link,
            'image'       => $this->image,
            'view'        => intval($this->view),
            'play'        => intval($this->play),
            'vote'        => intval($this->vote),
            'author'      => isset($this->author->name) ? $this->author->name : 'Unknown',
            'singers'     => empty($this->singers) ? [] : $this->singers->pluck('name'),
            'publish_at'  => date_format($this->publish_at, 'Y-m-d H:i:s'),
        ];
    }

}
