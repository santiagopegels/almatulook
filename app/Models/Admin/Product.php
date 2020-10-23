<?php

namespace App\Models\Admin;

use App\ProductAttributeValue;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Product
 * @package App\Models\Admin
 * @version September 14, 2020, 12:57 pm UTC
 *
 * @property string $name
 * @property number $price
 * @property number $cost_price
 */
class Product extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public $table = 'products';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'price',
        'cost_price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'price' => 'required',
        'cost_price' => 'required'
    ];

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('products');
    }

    public function getTotalStock(){
        return ProductAttributeValue::where('product_id', $this->id)->sum('stock');
    }

}
