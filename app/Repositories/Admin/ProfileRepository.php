<?php

namespace App\Repositories;

use App\Models\Admin\Profile;

/**
 * Class ProfileRepository
 * @package App\Repositories
 * @version January 8, 2021, 2:48 pm UTC
*/

class ProfileRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'lastname',
        'phone',
        'deliveryAddress',
        'flat',
        'city',
        'province',
        'cp'
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
        return Profile::class;
    }
}
