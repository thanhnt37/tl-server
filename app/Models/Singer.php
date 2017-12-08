<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Singer extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'singers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\SingerPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SingerObserver);
    }

    // Relations
    public function songs()
    {
        return $this->belongsToMany(\App\Models\Song::class, SingerSong::getTableName(), 'album_id', 'song_id');
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'image'       => $this->image,
        ];
    }

}
