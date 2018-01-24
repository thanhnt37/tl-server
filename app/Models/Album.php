<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'albums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'cover_image_id',
        'background_image_id',
        'vote',
        'publish_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['publish_at', 'deleted_at'];

    protected $presenter = \App\Presenters\AlbumPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\AlbumObserver);
    }

    // Relations
    public function coverImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'cover_image_id');
    }

    public function backgroundImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'background_image_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\App\Models\Song::class, AlbumSong::getTableName(), 'album_id', 'song_id');
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'description'      => $this->description,
            'background_image' => !empty($this->backgroundImage) ? $this->backgroundImage->present()->url : null,
            'cover_image'      => !empty($this->coverImage) ? $this->coverImage->present()->url : null,
            'vote'             => intval($this->vote),
            'publish_at'       => date_format($this->publish_at, 'Y-m-d H:i:s'),
        ];
    }

}
