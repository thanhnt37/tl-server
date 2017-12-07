<?php namespace App\Models;


class SingerSong extends Base
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'singer_songs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'singer_id',
        'song_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\SingerSongPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SingerSongObserver);
    }

    // Relations
    public function singer()
    {
        return $this->belongsTo(\App\Models\Singer::class, 'singer_id', 'id');
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
            'id'        => $this->id,
            'singer_id' => $this->singer_id,
            'song_id'   => $this->song_id,
        ];
    }

}
