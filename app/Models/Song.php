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
            'view'        => $this->view,
            'play'        => $this->play,
            'vote'        => $this->vote,
            'author_id'   => $this->author_id,
            'publish_at'  => date_format($this->publish_at, 'Y-m-d H:i:s'),
        ];
    }

}