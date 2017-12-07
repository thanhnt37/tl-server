<?php namespace App\Models;


class GenreSong extends Base
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genre_songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'genre_id',
        'song_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\GenreSongPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\GenreSongObserver);
    }

    // Relations
    public function genre()
    {
        return $this->belongsTo(\App\Models\Genre::class, 'genre_id', 'id');
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
            'genre_id' => $this->genre_id,
            'song_id'  => $this->song_id,
        ];
    }

}
