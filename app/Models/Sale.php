<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Base
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'box_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    protected $presenter = \App\Presenters\SalePresenter::class;

    public static function boot()
    {
        parent::boot();
        parent::observe(new \App\Observers\SaleObserver);
    }

    // Relations
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo(\App\Models\Box::class, 'box_id', 'id');
    }



    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'customer_id' => $this->customer_id,
            'box_id'      => $this->box_id,
        ];
    }

}
