<?php

namespace App\Models\Admin;

use App\Traits\Sluggable;
use Laratrust\Models\LaratrustRole;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models\Admin
 * @version August 7, 2020, 10:14 pm UTC
 *
 * @property string $name
 * @property string $display_name
 * @property string $description
 */
class Role extends LaratrustRole
{
    use SoftDeletes;
    use Sluggable;

    public $table = 'roles';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'display_name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'name' => 'required|unique:roles,name',
        'display_name' => 'required|unique:roles,display_name'
    ];
}
