<?php namespace App\Models;


class KaraVersion extends Base
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_versions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
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
    public function application()
    {
        return $this->hasOne(\App\Models\Application::class, 'id', 'application_id');
    }

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
            'id'          => $this->id,
            'application' => !empty($this->application) ? $this->application->name : 'Unknown',
            'version'     => intval($this->version),
            'name'        => $this->name,
            'description' => $this->description,
        ];
    }

}
