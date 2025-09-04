<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        if (! $request->user() || (! $request->user()->tokenCan('read-contacts') && ! $request->user()->isAdmin())) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return ContactMessage::query()
            ->latest()
            ->paginate(15);
    }

    public function show(Request $request, ContactMessage $contactMessage)
    {
        if (! $request->user() || (! $request->user()->tokenCan('read-contacts') && ! $request->user()->isAdmin())) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $contactMessage;
    }

    public function store(Request $request)
    {
        if (! $request->user() || (! $request->user()->tokenCan('create-contacts') && ! $request->user()->isAdmin())) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['required','email','max:255'],
            'subject'    => ['nullable','string','max:255'],
            'message'    => ['required','string','max:5000'],
            'newsletter' => ['nullable','boolean'],
        ]);

        $contact = ContactMessage::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'subject'    => $validated['subject'] ?? null,
            'message'    => $validated['message'],
            'newsletter' => (bool) ($validated['newsletter'] ?? false),
        ]);

        return response()->json($contact, Response::HTTP_CREATED);
    }
}

