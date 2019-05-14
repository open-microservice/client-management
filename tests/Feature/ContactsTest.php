<?php

namespace Tests\Feature;

use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Contact;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    public function testTheUserCanGetAllOfTheContacts()
    {
        factory(Contact::class)->times(5)->create();
        $this->json('GET','/api/contacts')->assertStatus(200)->assertJsonCount(5);
    }

    public function testTheUserCanGetASpecificContact()
    {
        $contact = factory(Contact::class)->create();

        $this->json('GET', '/api/contacts/'.$contact->identifier)
            ->assertStatus(200)
            ->assertJson($contact->toArray());
    }

    public function testTheUserCanGetContactsScopedByTheTenant()
    {
        $initialTenant = Uuid::uuid4()->toString();
        $secondaryTenant = Uuid::uuid4()->toString();
        factory(Contact::class)->times(3)->create(['tenant_id' => $initialTenant]);
        factory(Contact::class)->times(5)->create(['tenant_id' => $secondaryTenant]);

        $this->json('GET', '/api/contacts?tenant='.$initialTenant)
            ->assertStatus(200)
            ->assertJsonCount(3);

        $this->json('GET', '/api/contacts?tenant='.$secondaryTenant)
            ->assertStatus(200)
            ->assertJsonCount(5);
    }
}
