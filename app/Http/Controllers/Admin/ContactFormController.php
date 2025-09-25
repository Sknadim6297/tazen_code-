<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use App\Exports\ContactFormsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ContactFormController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactForm::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        // Date range filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        switch ($sortField) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'email':
                $query->orderBy('email', $sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        $submissions = $query->paginate(10);

        return view('admin.contacts.index', compact('submissions'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        
        // Build the same query as index method
        $query = ContactForm::query();

        // Apply the same filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $submissions = $query->latest()->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('admin.exports.contact-forms-pdf', compact('submissions'));
            return $pdf->download('contact-forms-' . date('Y-m-d') . '.pdf');
        } else {
            $export = new ContactFormsExport($submissions);
            return $export->toCsv();
        }
    }

    public function destroy(ContactForm $contactForm)
    {
        $contactForm->delete();
        return redirect()->route('admin.contact-forms.index')->with('success', 'Contact form submission deleted successfully');
    }
}
