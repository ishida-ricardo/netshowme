<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Models\Contact;
use App\Mail\ContactReceived;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $contact = new Contact($request->all());
        $contact->ip = $request->ip();
        $contact->file = $request->file->store('contacts');
        $contact->save();

        Mail::to(env('MAIL_TO'))->send(new ContactReceived($contact));

        return response()->json($contact, Response::HTTP_CREATED);
    }
}
