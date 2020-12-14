<?php

namespace App\Models\Admin;

use App\Traits\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models\Admin
 * @version September 3, 2020, 12:39 pm UTC
 *
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $category_parent_id
 */
class Category extends Model
{
    use SoftDeletes;
    use Sluggable;

    public $table = 'categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'slug',
        'description',
        'category_parent_id',
        'icon'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'description' => 'string',
        'category_parent_id' => 'integer',
        'icon' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'category_parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'categories_attributes')->with('values');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    static function getParentAndChildrenIdArray(Category $category)
    {
        $category = Category::with('childrenRecursive')->where('id', $category->id)->first();
        return Category::getCategoriesIds($category);
    }

    static function getCategoriesIds($category)
    {
        if (!empty($category)) {
            $array = array($category->id);
            if (count($category->childrenRecursive) == 0) return $array;
            else return array_merge($array, Category::getChildrenIds($category->childrenRecursive));
        } else return null;
    }

    static function getChildrenIds($subcategories)
    {
        $array = array();
        foreach ($subcategories as $subcategory) {
            array_push($array, $subcategory->id);
            if (count($subcategory->childrenRecursive))
                $array = array_merge($array, Category::getChildrenIds($subcategory->childrenRecursive));
        }
        return $array;
    }

}
