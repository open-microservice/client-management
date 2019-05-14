<?php

namespace Tests\Feature;

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
}
