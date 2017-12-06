<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class Box extends AuthenticatableBase
{

    use SoftDeletes, HasApiTokens;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boxes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imei',
        'serial',
        'box_version_id',
        'os_version_id',
        'sdk_version_id',
        'is_activated',
        'activation_date',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['activation_date', 'deleted_at'];

    protected $presenter = \App\Presenters\BoxPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\BoxObserver);
    }

    /**
     * Find the user identified by the given $identifier.
     *
     * @param $identifier email|phone
     *
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return $this->where('imei', $identifier)->first();
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
            'imei'            => $this->imei,
            'serial'          => $this->serial,
            'box_version_id'  => empty($this->boxVersion) ? null : $this->boxVersion->name,
            'os_version_id'   => empty($this->osVersion) ? null : $this->osVersion->name,
            'sdk_version_id'  => empty($this->sdkVersion) ? null : $this->sdkVersion->name,
            'is_activated'    => $this->is_activated ? true : false,
            'activation_date' => date_format($this->activation_date, 'Y-m-d H:i:s'),
        ];
    }

}
