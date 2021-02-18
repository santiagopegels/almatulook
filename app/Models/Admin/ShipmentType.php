<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShipmentType
 * @package App\Models\Admin
 * @version January 18, 2021, 1:23 pm UTC
 *
 * @property string $name
 * @property string $description
 * @property number $cost
 */
class ShipmentType extends Model
{
    use SoftDeletes;

    public $table = 'shipment_types';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'cost',
        'address_required'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'cost' => 'decimal:2',
        'address_required' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'cost' => 'required',
        'address_required' => 'required'
    ];

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

}
