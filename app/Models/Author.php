<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'authors';

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

    protected $presenter = \App\Presenters\AuthorPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\AuthorObserver);
    }

    // Relations
    public function songs()
    {
        return $this->hasMany(\App\Models\Song::class, 'author_id', 'id');
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'image'       => $this->image,
        ];
    }

}
