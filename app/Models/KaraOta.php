<?php namespace App\Models;


class KaraOta extends Base
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kara_ota';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'os_version',
        'box_version',
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
    public function karaVersion()
    {
        return $this->belongsTo(\App\Models\KaraVersion::class, 'kara_version_id', 'id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'os_version'      => $this->os_version,
            'box_version'     => $this->box_version,
            'kara_version_id' => $this->kara_version_id,
        ];
    }

}
