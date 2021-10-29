<?php

namespace App\Repositories\Admin;

use App\Models\Admin\PurchaseDetail;
use App\Repositories\BaseRepository;

/**
 * Class PurchaseDetailRepository
 * @package App\Repositories\Admin
 * @version November 6, 2020, 6:39 pm UTC
 */
class PurchaseDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'quantity',
        'price_purchase_moment',
        'subtotal'
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
        return PurchaseDetail::class;
    }

    public function index($input)
    {
        $purchaseId = $input['term'];

        $purchaseDetails = PurchaseDetail::where('purchase_id', $purchaseId)
            ->with('product')
            ->with('attributeValueGroup')
            ->get();

        return $purchaseDetails;
    }
}
