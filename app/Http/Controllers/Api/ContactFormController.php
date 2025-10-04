<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactFormController extends Controller
{
    public function __construct(
        private readonly ContactMessageService $contactService,
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'newsletter' => ['nullable', 'boolean'],
        ]);

        $contact = $this->contactService->submit($validated);

        return response()->json([
            'message' => 'Thank you. Your message has been sent.',
            'data' => [
                'id' => (string) $contact->getKey(),
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'newsletter' => $contact->newsletter,
                'created_at' => $contact->created_at?->toJSON(),
            ],
        ], Response::HTTP_CREATED);
    }
}
