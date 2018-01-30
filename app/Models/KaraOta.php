<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class KaraOta extends Base
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'app_ota';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'os_version_id',
        'sdk_version_id',
        'box_version_id',
        'kara_version_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\KaraOtaPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\KaraOtaObserver);
    }

    // Relations
    public function osVersion()
    {
        return $this->belongsTo(\App\Models\OsVersion::class, 'os_version_id', 'id');
    }
    public function sdkVersion()
    {
        return $this->belongsTo(\App\Models\SdkVersion::class, 'sdk_version_id', 'id');
    }
    public function karaVersion()
    {
        return $this->belongsTo(\App\Models\KaraVersion::class, 'kara_version_id', 'id');
    }
    public function boxVersion()
    {
        return $this->belongsTo(\App\Models\BoxVersion::class, 'box_version_id', 'id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'os_version_id'   => $this->os_version_id,
            'sdk_version_id'  => $this->sdk_version_id,
            'box_version_id'  => $this->box_version_id,
            'kara_version_id' => $this->kara_version_id,
        ];
    }

}
