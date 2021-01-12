<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Profile
 * @package App\Models\Admin
 * @version January 8, 2021, 2:48 pm UTC
 *
 * @property string $name
 * @property string $lastname
 * @property string $cellphone
 * @property string $deliveryAddress
 * @property string $flat
 * @property string $city
 * @property string $province
 * @property integer $cp
 */
class Profile extends Model
{
    use SoftDeletes;

    public $table = 'profiles';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'lastname',
        'cellphone',
        'deliveryAddress',
        'flat',
        'city',
        'province',
        'cp',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'lastname' => 'string',
        'cellphone' => 'string',
        'deliveryAddress' => 'string',
        'flat' => 'string',
        'city' => 'string',
        'province' => 'string',
        'cp' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'lastname' => 'required',
        'cellphone' => 'required | numeric | min: 9',
        'deliveryAddress' => 'required',
        'city' => 'required',
        'province' => 'required'
    ];


}
