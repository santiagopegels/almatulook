<?php

namespace App\Repositories\Admin;

use App\Models\Admin\StatusOrder;
use App\Repositories\BaseRepository;

/**
 * Class StatusOrderRepository
 * @package App\Repositories\Admin
 * @version February 9, 2021, 6:26 pm UTC
*/

class StatusOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status',
        'order'
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
        return StatusOrder::class;
    }
}
