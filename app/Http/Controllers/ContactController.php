<?php

namespace App\Http\Controllers;

use App\Services\ContactMessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactMessageService $contactService,
    ) {
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'newsletter' => ['nullable', 'boolean'],
        ]);

        $validated['newsletter'] = $request->boolean('newsletter');

        $this->contactService->submit($validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you. Your message has been sent.');
    }
}
