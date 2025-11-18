@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Edit Career Job</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.careers.index') }}">Career</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Edit Career Job</div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.careers.update', $career->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row gy-3">
                                <!-- Title -->
                                <div class="col-xl-12">
                                    <label for="title" class="form-label">Job Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $career->title) }}" required>
                                </div>

                                <!-- Location -->
                                <div class="col-xl-6">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" name="location" id="location" value="{{ old('location', $career->location) }}" placeholder="e.g., London, England, United Kingdom">
                                </div>

                                <!-- Job Type -->
                                <div class="col-xl-6">
                                    <label for="job_type" class="form-label">Job Type</label>
                                    <input type="text" class="form-control" name="job_type" id="job_type" value="{{ old('job_type', $career->job_type) }}" placeholder="e.g., Remote, Full-time">
                                </div>

                                <!-- Department -->
                                <div class="col-xl-6">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" name="department" id="department" value="{{ old('department', $career->department) }}" placeholder="e.g., Operations">
                                </div>

                                <!-- Status -->
                                <div class="col-xl-6">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="active" {{ old('status', $career->status) === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $career->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <!-- Description -->
                                <div class="col-xl-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Job description">{{ old('description', $career->description) }}</textarea>
                                </div>

                                <!-- Who are we? -->
                                <div class="col-xl-12">
                                    <label for="who_are_we" class="form-label">Who are we?</label>
                                    <textarea class="form-control" name="who_are_we" id="who_are_we" rows="4" placeholder="Company description">{{ old('who_are_we', $career->who_are_we) }}</textarea>
                                </div>

                                <!-- Expectation of the role -->
                                <div class="col-xl-12">
                                    <label for="expectation_of_role" class="form-label">Expectation of the role</label>
                                    <textarea class="form-control" name="expectation_of_role" id="expectation_of_role" rows="4" placeholder="Role expectations">{{ old('expectation_of_role', $career->expectation_of_role) }}</textarea>
                                </div>

                                <!-- Accounts Payable & Payroll -->
                                <div class="col-xl-12">
                                    <label for="accounts_payable_payroll" class="form-label">Accounts Payable & Payroll</label>
                                    <textarea class="form-control" name="accounts_payable_payroll" id="accounts_payable_payroll" rows="4" placeholder="Accounts payable and payroll details">{{ old('accounts_payable_payroll', $career->accounts_payable_payroll) }}</textarea>
                                </div>

                                <!-- Accounts Receivable -->
                                <div class="col-xl-12">
                                    <label for="accounts_receivable" class="form-label">Accounts Receivable</label>
                                    <textarea class="form-control" name="accounts_receivable" id="accounts_receivable" rows="4" placeholder="Accounts receivable details">{{ old('accounts_receivable', $career->accounts_receivable) }}</textarea>
                                </div>

                                <!-- Financial Reporting -->
                                <div class="col-xl-12">
                                    <label for="financial_reporting" class="form-label">Financial Reporting</label>
                                    <textarea class="form-control" name="financial_reporting" id="financial_reporting" rows="4" placeholder="Financial reporting details">{{ old('financial_reporting', $career->financial_reporting) }}</textarea>
                                </div>

                                <!-- Requirements -->
                                <div class="col-xl-12">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control" name="requirements" id="requirements" rows="4" placeholder="Job requirements (one per line)">{{ old('requirements', $career->requirements) }}</textarea>
                                </div>

                                <!-- What We Offer -->
                                <div class="col-xl-12">
                                    <label for="what_we_offer" class="form-label">What We Offer</label>
                                    <textarea class="form-control" name="what_we_offer" id="what_we_offer" rows="4" placeholder="Benefits and perks (one per line)">{{ old('what_we_offer', $career->what_we_offer) }}</textarea>
                                </div>
                            </div>

                            <div class="modal-footer mt-4">
                                <a href="{{ route('admin.careers.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    let editors = {};
    
    document.addEventListener('DOMContentLoaded', function() {
        // List of textarea IDs that need rich text editors
        const editorIds = [
            'description',
            'who_are_we',
            'expectation_of_role',
            'accounts_payable_payroll',
            'accounts_receivable',
            'financial_reporting',
            'requirements',
            'what_we_offer'
        ];

        // Initialize CKEditor for each textarea
        editorIds.forEach(function(editorId) {
            const textarea = document.querySelector('#' + editorId);
            if (textarea) {
                ClassicEditor
                    .create(textarea, {
                        toolbar: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'blockQuote',
                            'insertTable',
                            'undo',
                            'redo'
                        ],
                        placeholder: 'Enter content...',
                        height: '300px'
                    })
                    .then(newEditor => {
                        editors[editorId] = newEditor;
                        console.log('CKEditor initialized for: ' + editorId);
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor for ' + editorId + ':', error);
                    });
            }
        });

        // Handle form submission to sync CKEditor content
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Update each textarea with CKEditor content before form submission
                Object.keys(editors).forEach(function(editorId) {
                    if (editors[editorId]) {
                        const content = editors[editorId].getData();
                        document.querySelector('#' + editorId).value = content;
                    }
                });
            });
        }
    });
</script>
@endsection
