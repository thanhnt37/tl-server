<?php namespace App\Models;


class BoxVersion extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'box_versions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = [];

    protected $presenter = \App\Presenters\BoxVersionPresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\BoxVersionObserver);
    }

    // Relations


    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'name' => $this->name,
        ];
    }

}
