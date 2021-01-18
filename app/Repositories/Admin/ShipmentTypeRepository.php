<?php

namespace App\Repositories\Admin;

use App\Models\Admin\ShipmentType;
use App\Repositories\BaseRepository;

/**
 * Class ShipmentTypeRepository
 * @package App\Repositories\Admin
 * @version January 18, 2021, 1:23 pm UTC
*/

class ShipmentTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'cost'
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
        return ShipmentType::class;
    }
}
