<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\PurchaseDetail;

class PurchaseDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/purchase_details', $purchaseDetail
        );

        $this->assertApiResponse($purchaseDetail);
    }

    /**
     * @test
     */
    public function test_read_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/purchase_details/'.$purchaseDetail->id
        );

        $this->assertApiResponse($purchaseDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();
        $editedPurchaseDetail = factory(PurchaseDetail::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/purchase_details/'.$purchaseDetail->id,
            $editedPurchaseDetail
        );

        $this->assertApiResponse($editedPurchaseDetail);
    }

    /**
     * @test
     */
    public function test_delete_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/purchase_details/'.$purchaseDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/purchase_details/'.$purchaseDetail->id
        );

        $this->response->assertStatus(404);
    }
}
