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
        'category_parent_id'
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
        'category_parent_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];


}
