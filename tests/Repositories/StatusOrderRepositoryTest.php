<?php namespace Tests\Repositories;

use App\Models\Admin\StatusOrder;
use App\Repositories\Admin\StatusOrderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class StatusOrderRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var StatusOrderRepository
     */
    protected $statusOrderRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->statusOrderRepo = \App::make(StatusOrderRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->make()->toArray();

        $createdStatusOrder = $this->statusOrderRepo->create($statusOrder);

        $createdStatusOrder = $createdStatusOrder->toArray();
        $this->assertArrayHasKey('id', $createdStatusOrder);
        $this->assertNotNull($createdStatusOrder['id'], 'Created StatusOrder must have id specified');
        $this->assertNotNull(StatusOrder::find($createdStatusOrder['id']), 'StatusOrder with given id must be in DB');
        $this->assertModelData($statusOrder, $createdStatusOrder);
    }

    /**
     * @test read
     */
    public function test_read_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();

        $dbStatusOrder = $this->statusOrderRepo->find($statusOrder->id);

        $dbStatusOrder = $dbStatusOrder->toArray();
        $this->assertModelData($statusOrder->toArray(), $dbStatusOrder);
    }

    /**
     * @test update
     */
    public function test_update_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();
        $fakeStatusOrder = factory(StatusOrder::class)->make()->toArray();

        $updatedStatusOrder = $this->statusOrderRepo->update($fakeStatusOrder, $statusOrder->id);

        $this->assertModelData($fakeStatusOrder, $updatedStatusOrder->toArray());
        $dbStatusOrder = $this->statusOrderRepo->find($statusOrder->id);
        $this->assertModelData($fakeStatusOrder, $dbStatusOrder->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_status_order()
    {
        $statusOrder = factory(StatusOrder::class)->create();

        $resp = $this->statusOrderRepo->delete($statusOrder->id);

        $this->assertTrue($resp);
        $this->assertNull(StatusOrder::find($statusOrder->id), 'StatusOrder should not exist in DB');
    }
}
