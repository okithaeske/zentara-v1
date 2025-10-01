<?php

namespace App\Services;

use App\Mail\ContactSubmitted;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactMessageService
{
    public function submit(array $data): ContactMessage
    {
        $contact = ContactMessage::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
            'newsletter' => $this->resolveNewsletter($data['newsletter'] ?? false),
        ]);

        $this->notifyAdmin($contact);
        $this->notifyConfirmationService($contact);

        return $contact;
    }

    private function resolveNewsletter(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    private function notifyAdmin(ContactMessage $contact): void
    {
        $adminAddress = config('mail.from.address');

        if (! $adminAddress) {
            return;
        }

        Mail::to($adminAddress)->send(new ContactSubmitted($contact));
    }

    private function notifyConfirmationService(ContactMessage $contact): void
    {
        $endpoint = config('services.contact_confirmation.endpoint');

        if (! $endpoint) {
            return;
        }

        try {
            Http::post($endpoint, [
                'email' => $contact->email,
                'first_name' => $contact->first_name,
                'message' => $contact->message,
            ]);
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
