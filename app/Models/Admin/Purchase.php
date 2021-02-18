<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Purchase
 * @package App\Models\Admin
 * @version November 3, 2020, 3:33 pm UTC
 *
 * @property string $purchase_date
 * @property number $total
 */
class Purchase extends Model
{
    use SoftDeletes;

    public $table = 'purchases';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'total',
        'shipment_type_id',
        'shipment_cost',
        'status_order',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'total' => 'float',
        'shipment_type_id' => 'integer',
        'shipment_cost' => 'float',
        'status_order' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function shipment(){
        return $this->belongsTo(ShipmentType::class, 'shipment_type_id');
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
