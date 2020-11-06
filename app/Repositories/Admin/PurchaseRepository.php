<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\Product;
use App\Models\Admin\Purchase;
use App\Models\Admin\PurchaseDetail;
use App\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

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

    public function createPurchase($products){
        try {
            DB::beginTransaction();
            $totalPurchase = 0;
            $purchase = Purchase::create([
                'total' => $totalPurchase
            ]);
            foreach ($products as $product){
                $quantity = $product['quantity'];
                $productObject = Product::find($product['product_id']);

                $groupId = AttributeValueGroup::getGroupIdByAttributes($product['attributes']['attributes']);
                $productAttributesValuesGroup = ProductAttributeValueGroup::where('product_id', $productObject->id)
                    ->where('attribute_group_id', $groupId)->first();

                $totalPurchase += $quantity * $productObject->price;
                $productAttributesValuesGroup->stock -= $quantity;
                $productAttributesValuesGroup->save();

                PurchaseDetail::create([
                   'quantity' => $quantity,
                    'price_purchase_moment' => $productObject->price,
                    'subtotal' => $quantity * $productObject->price,
                    'product_id' => $productObject->id,
                    'purchase_id' => $purchase->id
                ]);
            }

            $purchase->total = $totalPurchase;
            $purchase->save();

            DB::commit();
            return $purchase;
        } catch(\Exception $e){
            $notification = [
                'alert-type' => 'error',
                'message' => __($e->getMessage()),
            ];
            DB::rollBack();
            return $notification;
        }

    }
}
