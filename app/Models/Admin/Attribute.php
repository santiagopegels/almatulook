<?php

namespace App\Models\Admin;

use App\Traits\Sluggable;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute
 * @package App\Models\Admin
 * @version September 1, 2020, 11:01 am UTC
 *
 * @property string $name
 * @property string $slug
 */
class Attribute extends Model
{
    use SoftDeletes;
    use Sluggable;

    public $table = 'attributes';


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
        'name' => 'required|unique:attributes'
    ];

    public function values(){
        return $this->belongsToMany(Value::class, 'attributes_values');
    }

}
