<?php

namespace Tests\Feature;

use App\Models\Client;
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
}
