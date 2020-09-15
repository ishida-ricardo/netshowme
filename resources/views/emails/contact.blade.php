<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact</title>
    </head>
    <body>
        <h1>New contact</h1>
        <p>
            Date: {{ $contact->created_at }} </br>
            IP: {{ $contact->ip }} </br>
            Name: {{ $contact->name }} </br>
            E-mail: {{ $contact->email }} </br>
            Phone: {{ $contact->phone }} </br>
            Message: {!! $contact->message !!} </br>
        </p>
    </body>
</html>
