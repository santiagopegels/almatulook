<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PurchaseDetail
 * @package App\Models\Admin
 * @version November 6, 2020, 6:39 pm UTC
 *
 * @property integer $quantity
 * @property number $price_purchase_moment
 * @property number $subtotal
 */
class PurchaseDetail extends Model
{
    use SoftDeletes;

    public $table = 'purchase_details';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'quantity',
        'price_purchase_moment',
        'subtotal',
        'product_id',
        'purchase_id',
        'group_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'quantity' => 'integer',
        'price_purchase_moment' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'product_id' => 'integer',
        'purchase_id' => 'integer',
        'group_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
