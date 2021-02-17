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
        'payment_site',
        'payment_id',
        'status',
        'payment_type',
        'preference_id',
        'merchant_order_id',
        'purchase_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'payment_site' => 'string',
        'status' => 'string',
        'payment_type' => 'string',
        'preference_id' => 'string',
        'merchant_order_id' => 'integer',
        'purchase_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function puchase(){
        return $this->belongsTo(Purchase::class);
    }
}
