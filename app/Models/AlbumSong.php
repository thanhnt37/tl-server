<?php namespace App\Models;


class AlbumSong extends Base
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'album_songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'album_id',
        'song_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\AlbumSongPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\AlbumSongObserver);
    }

    // Relations
    public function album()
    {
        return $this->belongsTo(\App\Models\Album::class, 'album_id', 'id');
    }

    public function song()
    {
        return $this->belongsTo(\App\Models\Song::class, 'song_id', 'id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'album_id' => $this->album_id,
            'song_id'  => $this->song_id,
        ];
    }

}
