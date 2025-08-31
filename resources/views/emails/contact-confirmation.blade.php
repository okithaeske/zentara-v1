<!DOCTYPE html>
<html>
<body>
    <p>Hi {{ $contact->first_name }},</p>
    <p>Thanks for reaching out to {{ config('app.name') }}. We received your message and will get back to you soon.</p>
    @if($contact->subject)
        <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    @endif
    <p><strong>Your Message:</strong></p>
    <p>{!! nl2br(e($contact->message)) !!}</p>
    <p>Best regards,<br>{{ config('app.name') }}</p>
</body>
</html>

