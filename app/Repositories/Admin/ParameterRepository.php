<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Parameter;
use App\Repositories\BaseRepository;

/**
 * Class ParameterRepository
 * @package App\Repositories\Admin
 * @version September 12, 2020, 3:41 pm UTC
*/

class ParameterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'parameter',
        'value'
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
        return Parameter::class;
    }
}
