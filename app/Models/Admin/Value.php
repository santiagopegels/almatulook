<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Value
 * @package App\Models\Admin
 * @version September 1, 2020, 10:12 pm UTC
 *
 * @property string $name
 * @property string $slug
 */
class Value extends Model
{
    use SoftDeletes;

    public $table = 'values';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:values'
    ];


}
