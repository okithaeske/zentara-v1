<?php

namespace App\Http\Controllers;

use App\Mail\ContactSubmitted;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'newsletter' => ['nullable'],
        ]);

        $contact = ContactMessage::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'newsletter' => (bool) $request->boolean('newsletter'),
        ]);

        $adminTo = config('mail.from.address');

        if ($adminTo) {
            Mail::to($adminTo)->send(new ContactSubmitted($contact));
        }

        // Customer-facing confirmation now handled by the external microservice.

        try {
            // Notify external confirmation API; failure should not block the user flow.
            Http::post('https://aitp9lkb4h.execute-api.eu-north-1.amazonaws.com/send-confirmation', [
                'email' => $contact->email,
                'first_name' => $contact->first_name,
                'message' => $contact->message,
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return redirect()->route('contact')->with('success', 'Thank you. Your message has been sent.');
    }
}
