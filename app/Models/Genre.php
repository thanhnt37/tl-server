<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genres';

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

    protected $presenter = \App\Presenters\GenrePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\GenreObserver);
    }

    // Relations
    public function songs()
    {
        return $this->belongsToMany(\App\Models\Song::class, GenreSong::getTableName(), 'genre_id', 'song_id');
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
