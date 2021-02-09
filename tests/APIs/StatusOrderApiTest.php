<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\StatusOrder;

class StatusOrderApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/status_orders', $statusOrder
        );

        $this->assertApiResponse($statusOrder);
    }

    /**
     * @test
     */
    public function test_read_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/status_orders/'.$statusOrder->id
        );

        $this->assertApiResponse($statusOrder->toArray());
    }

    /**
     * @test
     */
    public function test_update_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();
        $editedStatusOrder = factory(StatusOrder::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/status_orders/'.$statusOrder->id,
            $editedStatusOrder
        );

        $this->assertApiResponse($editedStatusOrder);
    }

    /**
     * @test
     */
    public function test_delete_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/status_orders/'.$statusOrder->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/status_orders/'.$statusOrder->id
        );

        $this->response->assertStatus(404);
    }
}
