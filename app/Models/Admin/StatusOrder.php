<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StatusOrder
 * @package App\Models\Admin
 * @version February 9, 2021, 6:26 pm UTC
 *
 * @property string $status
 * @property integer $order
 */
class StatusOrder extends Model
{
    use SoftDeletes;

    public $table = 'status_orders';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'status',
        'order',
        'can_delete_order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'string',
        'order' => 'integer',
        'can_delete_order' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
