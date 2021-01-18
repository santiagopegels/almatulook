<?php namespace Tests\Repositories;

use App\Models\Admin\ShipmentType;
use App\Repositories\Admin\ShipmentTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShipmentTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShipmentTypeRepository
     */
    protected $shipmentTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shipmentTypeRepo = \App::make(ShipmentTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->make()->toArray();

        $createdShipmentType = $this->shipmentTypeRepo->create($shipmentType);

        $createdShipmentType = $createdShipmentType->toArray();
        $this->assertArrayHasKey('id', $createdShipmentType);
        $this->assertNotNull($createdShipmentType['id'], 'Created ShipmentType must have id specified');
        $this->assertNotNull(ShipmentType::find($createdShipmentType['id']), 'ShipmentType with given id must be in DB');
        $this->assertModelData($shipmentType, $createdShipmentType);
    }

    /**
     * @test read
     */
    public function test_read_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();

        $dbShipmentType = $this->shipmentTypeRepo->find($shipmentType->id);

        $dbShipmentType = $dbShipmentType->toArray();
        $this->assertModelData($shipmentType->toArray(), $dbShipmentType);
    }

    /**
     * @test update
     */
    public function test_update_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();
        $fakeShipmentType = factory(ShipmentType::class)->make()->toArray();

        $updatedShipmentType = $this->shipmentTypeRepo->update($fakeShipmentType, $shipmentType->id);

        $this->assertModelData($fakeShipmentType, $updatedShipmentType->toArray());
        $dbShipmentType = $this->shipmentTypeRepo->find($shipmentType->id);
        $this->assertModelData($fakeShipmentType, $dbShipmentType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shipment_type()
    {
        $shipmentType = factory(ShipmentType::class)->create();

        $resp = $this->shipmentTypeRepo->delete($shipmentType->id);

        $this->assertTrue($resp);
        $this->assertNull(ShipmentType::find($shipmentType->id), 'ShipmentType should not exist in DB');
    }
}
