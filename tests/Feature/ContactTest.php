<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldValidationAllRequiredFields()
    {
        $response = $this->json('POST', '/api/contacts', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors([
                    'name',
                    'email',
                    'phone',
                    'message',
                    'file',
                ]);
    }

    public function testShouldNotCreateContactWithInvalidEmail()
    {
        $contact = Contact::factory()->make([
            'email' => 'invalid_email',
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function testShouldNotCreateContactWithInvalidPhone()
    {
        $contact = Contact::factory()->make([
            'phone' => '449959877810',
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['phone']);

        $contact = Contact::factory()->make([
            'phone' => '64519',
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['phone']);
    }

    public function testShouldNotCreateContactWithInvalidFileExtension()
    {
        $contact = Contact::factory()->make([
            'file' => UploadedFile::fake()->create('123.xls', 500)
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['file']);
    }

    public function testShouldNotCreateContactWithInvalidFileSize()
    {
        $contact = Contact::factory()->make([
            'file' => UploadedFile::fake()->create('123.pdf', 501)
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['file']);
    }

    public function testShouldCreateContactWithValidFields()
    {
        Storage::fake('contacts');
        $file = UploadedFile::fake()->create('123.pdf', 500);
        $contact = Contact::factory()->make([
            'file' => $file
        ]);
        $response = $this->json('POST', '/api/contacts', $contact->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas('contacts', [
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'message' => $contact->message,
            'ip' => '127.0.0.1',
        ]);
        Storage::disk()->assertExists($response['file']);
        Storage::disk()->delete($response['file']);
    }
}
