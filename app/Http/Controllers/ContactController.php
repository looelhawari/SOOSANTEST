<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a new contact message from the form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'newsletter' => 'sometimes|boolean',
        ]);

        // Set newsletter to false if not provided
        $validated['newsletter'] = $request->has('newsletter');

        // Create the contact message
        \App\Models\ContactMessage::create($validated);

        // Redirect back with success message
        return redirect()->back()->with('success', __('common.contact_success'));
    }
}
