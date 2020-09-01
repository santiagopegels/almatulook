<?php

namespace App\Models\Admin;

use Laratrust\Models\LaratrustPermission;
use App\Traits\Sluggable;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission
 * @package App\Models\Admin
 * @version August 8, 2020, 1:28 am UTC
 *
 * @property string $name
 * @property string $display_name
 * @property string $description
 */
class Permission extends LaratrustPermission
{
    use SoftDeletes;
    use Sluggable;

    public $table = 'permissions';


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
        'display_name' => 'required'
    ];
}
