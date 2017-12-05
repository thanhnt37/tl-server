<?php namespace App\Models;


class KaraVersion extends Base
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kara_versions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version',
        'name',
        'description',
        'apk_package_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\KaraVersionPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\KaraVersionObserver);
    }

    // Relations
    public function apkPackage()
    {
        return $this->hasOne(\App\Models\File::class, 'id', 'apk_package_id');
    }


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'version'     => $this->version,
            'name'        => $this->name,
            'description' => $this->description,
        ];
    }

}
