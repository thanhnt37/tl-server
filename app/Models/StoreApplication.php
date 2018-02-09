<?php
namespace App\Models;

class StoreApplication extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'store_applications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'version_name',
        'version_code',
        'package_name',
        'description',
        'tags',
        'icon_image_id',
        'background_image_id',
        'hit',
        'min_sdk',
        'apk_package_id',
        'category_id',
        'developer_id',
        'publish_started_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['publish_started_at'];

    protected $presenter = \App\Presenters\StoreApplicationPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\StoreApplicationObserver);
    }

    // Relations
    public function iconImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'icon_image_id');
    }

    public function backgroundImage()
    {
        return $this->hasOne(\App\Models\Image::class, 'id', 'background_image_id');
    }

    public function apkPackage()
    {
        return $this->hasOne(\App\Models\File::class, 'id', 'apk_package_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }

    public function developer()
    {
        return $this->belongsTo(\App\Models\Developer::class, 'developer_id', 'id');
    }
    
    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                 => $this->id,
            'name'               => $this->name,
            'version_name'       => $this->version_name,
            'version_code'       => intval($this->version_code),
            'package_name'       => $this->package_name,
            'apk_package_url'    => isset($this->apkPackage->url) ? \URLHelper::asset(config('file.categories.store-app_apk.local_path') . $this->apkPackage->url, config('file.categories.store-app_apk.local_type')) : '',
            'description'        => $this->description,
            'tags'               => $this->tags,
            'icon_image'         => !empty($this->iconImage) ? $this->iconImage->present()->url : null,
            'background_image'   => !empty($this->backgroundImage) ? $this->backgroundImage->present()->url : null,
            'hit'                => intval($this->hit),
            'min_sdk'            => intval($this->min_sdk),
            'category'           => !empty($this->category) ? $this->category->name : null,
            'type'               => !empty($this->category) ? ($this->category->type ? 'Games' : 'Applications') : null,
            'developer'          => !empty($this->developer) ? $this->developer->name : null,
            'publish_started_at' => $this->publish_started_at->format('Y-m-d H:i:s'),
        ];
    }

}
