<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AttributeValueGroup;
use App\Models\Admin\Payment;
use App\Models\Admin\Product;
use App\Models\Admin\Profile;
use App\Models\Admin\Purchase;
use App\Models\Admin\PurchaseDetail;
use App\PaymentMethods\MercadoPago;
use App\ProductAttributeValueGroup;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
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

    public function createPurchase($products, $shipmentType = array('id' => null, 'cost' => 0), $statusOrder = null, $preferenceId = null)
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

                if ($productAttributesValuesGroup->stock > 0) {
                    $productAttributesValuesGroup->stock -= $quantity;
                } else {
                    throw new \Exception('El producto ' . $productObject->name . ' no tiene stock.');
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

            if(!is_null($preferenceId)){
                MercadoPago::updateExternalReference($preferenceId, $purchase);
                Payment::create([
                    'status' => 'pending',
                    'preference_id' => $preferenceId,
                    'purchase_id' => $purchase->id
                ]);
            }

            DB::commit();
            return $purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            abort(400, $e->getMessage());
        }
    }

    public function registerPayer($payer, $purchase)
    {
        if (!$payer['isGuest'] && Auth::check()) {
            $profile = Profile::where('user_id', Auth::id())->first();
            $purchase->profile()->associate($profile);
            $purchase->save();
        } else {
            $data = $payer['data'];
            $profile = Profile::create([
                'name' => $data['profile']['personalInfo']['name'],
                'lastname' => $data['profile']['personalInfo']['lastName'],
                'email' => $data['user']['email'],
                'cellphone' => $data['profile']['contact']['cellphone'],
                'deliveryAddress' => $data['profile']['contact']['address']['deliveryAddress'],
                'flat' => $data['profile']['contact']['address']['flat'],
                'city' => $data['profile']['contact']['address']['city'],
                'province' => $data['profile']['contact']['address']['province'],
                'cp' => $data['profile']['contact']['address']['cp'],
            ]);
            $purchase->profile()->associate($profile);
            $purchase->save();
        }
    }

    static function deletePurchase($purchase){
        $purchaseDetails = $purchase->purchaseDetails;

        foreach ($purchaseDetails as $purchaseDetail){

            $productAttributeValueGroup = ProductAttributeValueGroup::where('product_id', $purchaseDetail->product->id)
                ->where('attribute_group_id', $purchaseDetail->group_id)->first();

            $productAttributeValueGroup->stock = $productAttributeValueGroup->stock + $purchaseDetail->quantity;
            $productAttributeValueGroup->save();
            $purchaseDetail->delete();
        }

        $purchase->delete();

        return $purchase;
    }
}
