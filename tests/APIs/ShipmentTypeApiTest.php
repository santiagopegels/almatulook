<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\ShipmentType;

class ShipmentTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/shipment_types', $shipmentType
        );

        $this->assertApiResponse($shipmentType);
    }

    /**
     * @test
     */
    public function test_read_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/shipment_types/'.$shipmentType->id
        );

        $this->assertApiResponse($shipmentType->toArray());
    }

    /**
     * @test
     */
    public function test_update_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();
        $editedShipmentType = factory(ShipmentType::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/shipment_types/'.$shipmentType->id,
            $editedShipmentType
        );

        $this->assertApiResponse($editedShipmentType);
    }

    /**
     * @test
     */
    public function test_delete_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/shipment_types/'.$shipmentType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/shipment_types/'.$shipmentType->id
        );

        $this->response->assertStatus(404);
    }
}
