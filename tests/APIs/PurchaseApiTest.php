<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Purchase;

class PurchaseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_purchase()
    {
        $purchase = factory(Purchase::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/purchases', $purchase
        );

        $this->assertApiResponse($purchase);
    }

    /**
     * @test
     */
    public function test_read_purchase()
    {
        $purchase = factory(Purchase::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/purchases/'.$purchase->id
        );

        $this->assertApiResponse($purchase->toArray());
    }

    /**
     * @test
     */
    public function test_update_purchase()
    {
        $purchase = factory(Purchase::class)->create();
        $editedPurchase = factory(Purchase::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/purchases/'.$purchase->id,
            $editedPurchase
        );

        $this->assertApiResponse($editedPurchase);
    }

    /**
     * @test
     */
    public function test_delete_purchase()
    {
        $purchase = factory(Purchase::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/purchases/'.$purchase->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/purchases/'.$purchase->id
        );

        $this->response->assertStatus(404);
    }
}
