<?php namespace Tests\Repositories;

use App\Models\Admin\Value;
use App\Repositories\Admin\ValueRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ValueRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ValueRepository
     */
    protected $valueRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->valueRepo = \App::make(ValueRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_value()
    {
        $value = factory(Value::class)->make()->toArray();

        $createdValue = $this->valueRepo->create($value);

        $createdValue = $createdValue->toArray();
        $this->assertArrayHasKey('id', $createdValue);
        $this->assertNotNull($createdValue['id'], 'Created Value must have id specified');
        $this->assertNotNull(Value::find($createdValue['id']), 'Value with given id must be in DB');
        $this->assertModelData($value, $createdValue);
    }

    /**
     * @test read
     */
    public function test_read_value()
    {
        $value = factory(Value::class)->create();

        $dbValue = $this->valueRepo->find($value->id);

        $dbValue = $dbValue->toArray();
        $this->assertModelData($value->toArray(), $dbValue);
    }

    /**
     * @test update
     */
    public function test_update_value()
    {
        $value = factory(Value::class)->create();
        $fakeValue = factory(Value::class)->make()->toArray();

        $updatedValue = $this->valueRepo->update($fakeValue, $value->id);

        $this->assertModelData($fakeValue, $updatedValue->toArray());
        $dbValue = $this->valueRepo->find($value->id);
        $this->assertModelData($fakeValue, $dbValue->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_value()
    {
        $value = factory(Value::class)->create();

        $resp = $this->valueRepo->delete($value->id);

        $this->assertTrue($resp);
        $this->assertNull(Value::find($value->id), 'Value should not exist in DB');
    }
}
