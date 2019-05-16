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

    public function testTheContactCanBeCreated()
    {
        $contact = factory(Contact::class)->make();

        $this->json('POST', '/api/contacts', $contact->toArray())->assertStatus(201);

        $this->assertDatabaseHas('contacts', $contact->toArray());
    }

    public function testTheContactCanBeCreatedAndAssignedToATenant()
    {
        $initialTenant = Uuid::uuid4()->toString();
        $contact = factory(Contact::class)->make(['tenant_id' => $initialTenant]);

        $this->json('POST', '/api/contacts', $contact->toArray())->assertStatus(201);

        $this->assertDatabaseHas('contacts', [
            'tenant_id' => $initialTenant,
            'first_name' => $contact->first_name
        ]);
    }

    public function testTheContactCanBeUpdated()
    {
        $contact = factory(Contact::class)->create();
        $this->json('PUT', '/api/contacts/'.$contact->identifier, array_merge($contact->toArray(), ['first_name' => 'John']));

        $this->assertDatabaseHas('contacts', [
            'identifier' => $contact->identifier,
            'first_name' => 'John'
        ]);
    }

    public function testTheContactCanBeDeleted()
    {
        $contact = factory(Contact::class)->create();
        $this->assertNull($contact->deleted_at);

        $this->json('DELETE', '/api/contacts/'.$contact->identifier);

        $this->assertNotNull($contact->fresh()->deleted_at);
    }
}
