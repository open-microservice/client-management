<?php

namespace Tests\Feature;

use App\Models\Client;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientsTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetAllOfTheClients()
    {
        factory(Client::class)->times(5)->create();
        $response = $this->json('GET', '/api/clients')->assertStatus(200)->json();

        $this->assertCount(5, $response);
    }

    public function testTheUserCanGetASpecificClient()
    {
        $client = factory(Client::class)->create();

        $this->json('GET', '/api/clients/'.$client->identifier)
            ->assertStatus(200)
            ->assertJson($client->toArray());
    }

    public function testTheUserCanGetClientsScopedByTheTenant()
    {
        $initialTenant = Uuid::uuid4()->toString();
        $secondaryTenant = Uuid::uuid4()->toString();
        factory(Client::class)->times(3)->create(['tenant_id' => $initialTenant]);
        factory(Client::class)->times(5)->create(['tenant_id' => $secondaryTenant]);

        $this->json('GET', '/api/clients?tenant='.$initialTenant)
             ->assertStatus(200)
             ->assertJsonCount(3);

        $this->json('GET', '/api/clients?tenant='.$secondaryTenant)
             ->assertStatus(200)
             ->assertJsonCount(5);
    }
}
