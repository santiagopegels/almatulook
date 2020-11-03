<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Purchase;
use App\Repositories\BaseRepository;

/**
 * Class PurchaseRepository
 * @package App\Repositories\Admin
 * @version November 3, 2020, 3:33 pm UTC
*/

class PurchaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'purchase_date',
        'total'
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
        return Purchase::class;
    }
}
