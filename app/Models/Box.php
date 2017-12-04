<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Base
{

    use SoftDeletes;

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
        'model',
        'os_version',
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

    // Relations


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'              => $this->id,
            'imei'            => $this->imei,
            'serial'          => $this->serial,
            'model'           => $this->model,
            'os_version'      => $this->os_version,
            'is_activated'    => $this->is_activated,
            'activation_date' => $this->activation_date,
        ];
    }

}
