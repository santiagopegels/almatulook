<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Parameter
 * @package App\Models\Admin
 * @version September 12, 2020, 3:41 pm UTC
 *
 * @property string $parameter
 * @property string $value
 */
class Payment extends Model
{
    use SoftDeletes;

    public $table = 'payments';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'payment_method',
        'voucher_payment',
        'status',
        'purchase_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'voucher_payment' => 'string',
        'status' => 'string',
        'purchase_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
