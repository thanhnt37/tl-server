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
        'image',
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
            'vote'        => $this->vote,
            'publish_at'  => date_format($this->publish_at, 'Y-m-d H:i:s'),
        ];
    }

}
