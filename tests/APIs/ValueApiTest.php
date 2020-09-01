<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Admin\Value;

class ValueApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_value()
    {
        $value = factory(Value::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/admin/values', $value
        );

        $this->assertApiResponse($value);
    }

    /**
     * @test
     */
    public function test_read_value()
    {
        $value = factory(Value::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/admin/values/'.$value->id
        );

        $this->assertApiResponse($value->toArray());
    }

    /**
     * @test
     */
    public function test_update_value()
    {
        $value = factory(Value::class)->create();
        $editedValue = factory(Value::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/admin/values/'.$value->id,
            $editedValue
        );

        $this->assertApiResponse($editedValue);
    }

    /**
     * @test
     */
    public function test_delete_value()
    {
        $value = factory(Value::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/admin/values/'.$value->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/admin/values/'.$value->id
        );

        $this->response->assertStatus(404);
    }
}
