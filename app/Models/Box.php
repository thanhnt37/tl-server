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

    /**
     * Find the user identified by the given $identifier.
     *
     * @param $identifier email|phone
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return $this->where('imei', $identifier)->first();
    }

    // Relations


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'imei'            => $this->imei,
            'serial'          => $this->serial,
            'model'           => $this->model,
            'os_version'      => $this->os_version,
            'is_activated'    => $this->is_activated ? true : false,
            'activation_date' => date_format($this->activation_date, 'Y-m-d H:i:s'),
        ];
    }

}
