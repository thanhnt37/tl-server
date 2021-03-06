<?php
namespace App\Models;

class Category extends Base
{
    const CATEGORY_TYPE_APP  = 0;
    const CATEGORY_TYPE_GAME = 1;
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'cover_image_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\CategoryPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\CategoryObserver);
    }

    // Relations
    public function coverImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'cover_image_id');
    }

    public function storeApplication()
    {
        return $this->hasMany(\App\Models\StoreApplication::class , 'category_id', 'id');
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
            'type'        => $this->type ? 'Games' : 'Applications',
            'cover_image' => !empty($this->coverImage) ? $this->coverImage->present()->url : null,
        ];
    }

}
