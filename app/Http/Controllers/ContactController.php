<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactMessage = ContactMessage::create($validated);

        $settings = Setting::getAllSettings();
        $adminEmail = $settings['contact_email'] ?? $settings['contact_email_2'] ?? null;

        if ($adminEmail) {
            try {
                Mail::raw(
                    "New contact message from {$contactMessage->name} ({$contactMessage->email})\n\nSubject: {$contactMessage->subject}\n\nMessage:\n{$contactMessage->message}",
                    function ($message) use ($adminEmail, $contactMessage) {
                        $message->to($adminEmail)
                            ->subject("New Contact Message: {$contactMessage->subject}");
                    }
                );
            } catch (\Exception $e) {
                // Log error but don't fail the request
            }
        }

        return redirect('/#contact')->with('success', __('messages.Contact message sent successfully'));
    }

    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);

        return view('contact-messages.index', compact('messages'));
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()->route('contact-messages.index')->with('success', __('messages.Message deleted'));
    }
}
