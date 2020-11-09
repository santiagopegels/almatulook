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
        'total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'total' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}