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
        'wildcard',
        'name',
        'slug_name',
        'description',
        'cover_image_id',
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
    public function coverImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'cover_image_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\App\Models\Song::class, SingerSong::getTableName(), 'singer_id', 'song_id');
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'wildcard'    => $this->wildcard,
            'name'        => $this->name,
            'description' => $this->description,
            'cover_image' => !empty($this->coverImage) ? $this->coverImage->present()->url : 'http://placehold.it/640x480?text=No%20Image',
        ];
    }

}
