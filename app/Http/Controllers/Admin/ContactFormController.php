<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function index()
    {
        $submissions = ContactForm::latest()->paginate(10);
        return view('admin.contacts.index', compact('submissions'));
    }

    public function destroy(ContactForm $contactForm)
    {
        $contactForm->delete();
        return redirect()->route('admin.contact-forms.index')->with('success', 'Contact form submission deleted successfully');
    }
}
