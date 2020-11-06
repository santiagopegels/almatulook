<?php namespace Tests\Repositories;

use App\Models\Admin\PurchaseDetail;
use App\Repositories\Admin\PurchaseDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PurchaseDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PurchaseDetailRepository
     */
    protected $purchaseDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->purchaseDetailRepo = \App::make(PurchaseDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->make()->toArray();

        $createdPurchaseDetail = $this->purchaseDetailRepo->create($purchaseDetail);

        $createdPurchaseDetail = $createdPurchaseDetail->toArray();
        $this->assertArrayHasKey('id', $createdPurchaseDetail);
        $this->assertNotNull($createdPurchaseDetail['id'], 'Created PurchaseDetail must have id specified');
        $this->assertNotNull(PurchaseDetail::find($createdPurchaseDetail['id']), 'PurchaseDetail with given id must be in DB');
        $this->assertModelData($purchaseDetail, $createdPurchaseDetail);
    }

    /**
     * @test read
     */
    public function test_read_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();

        $dbPurchaseDetail = $this->purchaseDetailRepo->find($purchaseDetail->id);

        $dbPurchaseDetail = $dbPurchaseDetail->toArray();
        $this->assertModelData($purchaseDetail->toArray(), $dbPurchaseDetail);
    }

    /**
     * @test update
     */
    public function test_update_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();
        $fakePurchaseDetail = factory(PurchaseDetail::class)->make()->toArray();

        $updatedPurchaseDetail = $this->purchaseDetailRepo->update($fakePurchaseDetail, $purchaseDetail->id);

        $this->assertModelData($fakePurchaseDetail, $updatedPurchaseDetail->toArray());
        $dbPurchaseDetail = $this->purchaseDetailRepo->find($purchaseDetail->id);
        $this->assertModelData($fakePurchaseDetail, $dbPurchaseDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_purchase_detail()
    {
        $purchaseDetail = factory(PurchaseDetail::class)->create();

        $resp = $this->purchaseDetailRepo->delete($purchaseDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(PurchaseDetail::find($purchaseDetail->id), 'PurchaseDetail should not exist in DB');
    }
}
