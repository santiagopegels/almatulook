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
class Parameter extends Model
{
    use SoftDeletes;

    public $table = 'parameters';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'parameter',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parameter' => 'string',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'parameter' => 'unique'
    ];

    
}
