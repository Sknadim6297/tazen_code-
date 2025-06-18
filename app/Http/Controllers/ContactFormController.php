<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name_contact' => 'required|string|max:255',
            'email_contact' => 'required|email|max:255',
            'phone_contact' => 'required|digits:10',
            'message_contact' => 'required|string',
            'verify_contact' => 'required|string'
        ]);

        ContactForm::create([
            'name' => $request->name_contact,
            'email' => $request->email_contact,
            'phone' => $request->phone_contact,
            'message' => $request->message_contact,
            'verification_answer' => $request->verify_contact
        ]);

        return redirect()->back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}
