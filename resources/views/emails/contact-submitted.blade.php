<!DOCTYPE html>
<html>
<body>
    <h2>New Contact Message</h2>
    <p><strong>Name:</strong> {{ $contact->first_name }} {{ $contact->last_name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    @if($contact->subject)
        <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    @endif
    <p><strong>Wants Newsletter:</strong> {{ $contact->newsletter ? 'Yes' : 'No' }}</p>
    <hr>
    <p>{!! nl2br(e($contact->message)) !!}</p>
</body>
</html>

