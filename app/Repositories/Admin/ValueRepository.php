<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Value;
use App\Repositories\BaseRepository;

/**
 * Class ValueRepository
 * @package App\Repositories\Admin
 * @version September 1, 2020, 10:12 pm UTC
*/

class ValueRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Value::class;
    }
}
