<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Requests\ContactRequest;

class ContactRequestTest extends TestCase
{
    
    public function testShouldAuthorizeTheRequest()
    {
        $request = new ContactRequest();
        $this->assertTrue($request->authorize());
    }

    public function testShouldContainAllTheExpectedValidationRules()
    {
        $request = new ContactRequest();
    
        $this->assertEquals([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^[0-9]{11}$/',
            'message' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,odt,txt|max:500'
        ], $request->rules());
    }
}
