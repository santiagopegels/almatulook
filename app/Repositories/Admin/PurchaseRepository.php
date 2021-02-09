<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\Product;
use App\Models\Admin\Purchase;
use App\Models\Admin\PurchaseDetail;
use App\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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

    public function createPurchase($products, $shipmentType = array('id' => null, 'cost' => 0), $statusOrder = null)
    {
        try {
            DB::beginTransaction();
            $totalPurchase = 0;
            $shipmentType = (object)$shipmentType;
            $purchase = Purchase::create([
                'total' => $totalPurchase
            ]);
            foreach ($products as $product) {
                isset($product['product_id']) ? $productId = $product['product_id'] : $productId = $product['id'];
                isset($product['attributes']['attributes']) ? $attributes = $product['attributes']['attributes'] : $attributes = $product['attributeValueSelected'];
                $quantity = $product['quantity'];
                $productObject = Product::find($productId);

                $groupId = AttributeValueGroup::getGroupIdByAttributes($attributes);
                $productAttributesValuesGroup = ProductAttributeValueGroup::where('product_id', $productObject->id)
                    ->where('attribute_group_id', $groupId)->first();

                $totalPurchase += $quantity * $productObject->price;

                if($productAttributesValuesGroup->stock > 0){
                    $productAttributesValuesGroup->stock -= $quantity;
                } else {
                    throw new \Exception('El producto '.$productObject->name.' no tiene stock.');
                }

                $productAttributesValuesGroup->save();

                PurchaseDetail::create([
                    'quantity' => $quantity,
                    'price_purchase_moment' => $productObject->price,
                    'subtotal' => $quantity * $productObject->price,
                    'product_id' => $productObject->id,
                    'purchase_id' => $purchase->id,
                    'group_id' => $groupId
                ]);
            }

            $purchase->total = $totalPurchase;
            $purchase->shipment_type_id = $shipmentType->id;
            $purchase->shipment_cost = $shipmentType->cost;
            $purchase->status_order = 0;
            $purchase->save();
            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            abort(400, $e->getMessage());
        }
    }
}
