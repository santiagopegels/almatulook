<?php

namespace App\Models\Admin;

use App\ProductAttributeValueGroup;
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
        'cost_price',
        'category_id'
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
        'cost_price' => 'decimal:2',
        'category_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'price' => 'required',
        'cost_price' => 'required',
        'category_id' => 'required',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products');
    }

    public function getTotalStock()
    {
        return ProductAttributeValueGroup::where('product_id', $this->id)->sum('stock');
    }

    public function getImages()
    {
        $images = $this->getMedia('products');
        if ($images) {
            $imagesURL = [];
            foreach ($images as $image) {
                array_push($imagesURL, $image->getUrl());
            }
        }

        return $imagesURL;
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->with('children');
    }

    public function productAttributeValueGroup(){
        return $this->hasMany(ProductAttributeValueGroup::class);
    }

    public function stockAttributes()
    {
        $attributes = array();
        foreach ($this->productAttributeValueGroup as $productAttributesGroup){
            $attributeArray = array();
            $attributeArray['stock'] = $productAttributesGroup->stock;
            $attributeObject = array();
            foreach ($productAttributesGroup->attributeValueGroup as $attributeValueGroup){
                $attributeObject[] = [
                    'id_value' => $attributeValueGroup->attributeValue->value->id,
                    $attributeValueGroup->attributeValue->attribute->name => $attributeValueGroup->attributeValue->value->name
                ];
            }
            $attributeArray['attributes'] = $attributeObject;
            array_push($attributes,$attributeArray);
        }
        return $attributes;
    }

}
