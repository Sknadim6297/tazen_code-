@extends('professional.layout.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('professional/assets/css/other.css') }}" />
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --muted: #64748b;
        --page-bg: #f4f6fb;
        --card-bg: #ffffff;
        --border: rgba(148, 163, 184, 0.22);
    }

    body,
    .app-content {
        background: var(--page-bg);
    }

    .requested-create-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .requested-create-shell {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .create-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.2rem;
        padding: 2rem 2.3rem;
        border-radius: 26px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 48px rgba(79, 70, 229, 0.16);
    }

    .create-hero::before,
    .create-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .create-hero::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .create-hero::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .create-hero > * { position: relative; z-index: 1; }

    .hero-meta {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        color: var(--muted);
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 1rem;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.35);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: #0f172a;
    }

    .hero-meta h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #0f172a;
    }

    .hero-breadcrumb {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        font-size: 0.86rem;
        color: var(--muted);
    }

    .hero-breadcrumb li a {
        color: var(--primary);
        text-decoration: none;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 2.1rem 2.3rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .form-card h2 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }

    .form-group label {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.7rem 0.85rem;
        font-size: 0.92rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    textarea.form-control { min-height: 120px; resize: vertical; }

    .dynamic-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        align-items: end;
        padding: 1rem;
        background: rgba(248, 250, 252, 0.8);
        border-radius: 16px;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .dynamic-toolbar {
        display: flex;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-neutral,
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 999px;
        border: none;
        padding: 0.75rem 1.45rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(79, 70, 229, 0.22);
    }

    .btn-neutral {
        background: rgba(148, 163, 184, 0.18);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-outline {
        background: transparent;
        color: var(--muted);
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-primary:hover,
    .btn-neutral:hover,
    .btn-outline:hover { transform: translateY(-1px); }

    .remove-service,
    .remove-education {
        background: rgba(248, 113, 113, 0.18);
        color: #b91c1c;
        border-radius: 12px;
        padding: 0.55rem 1.1rem;
        border: none;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        .requested-create-page { padding: 2.2rem 1rem 3.2rem; }
        .create-hero { padding: 1.75rem 1.6rem; }
        .form-card { padding: 1.7rem 1.6rem; }
    }
</style>
@endsection

@section('content')
<div class="requested-create-page">
    <div class="requested-create-shell">
        <section class="create-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-clipboard-list"></i>Information</span>
                <h1>Add Other Information</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Other Information</li>
                </ul>
            </div>
        </section>

        <section class="form-card">
            <h2>Information Details</h2>
            <form id="serviceForm">
                @csrf
                <div class="form-group">
                    <label for="sub_heading">Services Details *</label>
                    <textarea name="sub_heading" id="sub_heading" class="form-control" placeholder="Describe the services you can offer..." required></textarea>
                </div>

                <div class="dynamic-toolbar">
                    <strong style="font-size:0.92rem; color:#0f172a;">Requested Services</strong>
                    <button type="button" id="addService" class="btn-neutral" style="padding:0.55rem 1rem;">
                        <i class="fas fa-plus"></i> Add Service
                    </button>
                </div>
                <div id="requestedServicesContainer" style="display:flex; flex-direction:column; gap:1rem;">
                    <div class="dynamic-group requested-service">
                        <div class="form-group">
                            <label>Requested Service *</label>
                            <input type="text" name="requested_service[]" class="form-control" placeholder="Add service you can offer" required>
                        </div>
                        <div class="form-group">
                            <label>Price *</label>
                            <input type="number" name="price[]" class="form-control" step="0.01" placeholder="Enter price" required>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top:1.5rem;">
                    <label for="education_statement">Education Statement</label>
                    <textarea name="education_statement" id="education_statement" class="form-control" rows="4" placeholder="Share details about your education and credentials..."></textarea>
                </div>

                <div class="dynamic-toolbar">
                    <strong style="font-size:0.92rem; color:#0f172a;">Education</strong>
                    <button type="button" id="addEducation" class="btn-neutral" style="padding:0.55rem 1rem;">
                        <i class="fas fa-plus"></i> Add Education
                    </button>
                </div>
                <div id="educationContainer" style="display:flex; flex-direction:column; gap:1rem;">
                    <div class="dynamic-group education-entry">
                        <div class="form-group">
                            <label>College Name</label>
                            <input type="text" name="college_name[]" class="form-control" placeholder="Enter college name">
                        </div>
                        <div class="form-group">
                            <label>Degree</label>
                            <input type="text" name="degree[]" class="form-control" placeholder="Enter degree">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('professional.requested_services.index') }}" class="btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i>
                        Save
                    </button>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#addService').click(function () {
    $('#requestedServicesContainer').append(`
        <div class="dynamic-group requested-service">
            <div class="form-group">
                <label>Requested Service *</label>
                <input type="text" name="requested_service[]" class="form-control" placeholder="Add service you can offer" required>
            </div>
            <div class="form-group">
                <label>Price *</label>
                <input type="number" name="price[]" class="form-control" placeholder="Enter price" step="0.01" required>
            </div>
            <div class="form-group" style="align-self:flex-start;">
                <button type="button" class="remove-service">Delete</button>
            </div>
        </div>
    `);
});

$('#addEducation').click(function () {
    $('#educationContainer').append(`
        <div class="dynamic-group education-entry">
            <div class="form-group">
                <label>College Name</label>
                <input type="text" name="college_name[]" class="form-control" placeholder="Enter college name" required>
            </div>
            <div class="form-group">
                <label>Degree</label>
                <input type="text" name="degree[]" class="form-control" placeholder="Enter degree" required>
            </div>
            <div class="form-group" style="align-self:flex-start;">
                <button type="button" class="remove-education">Delete</button>
            </div>
        </div>
    `);
});

$(document).on('click', '.remove-service', function () {
    $(this).closest('.requested-service').remove();
});

$(document).on('click', '.remove-education', function () {
    $(this).closest('.education-entry').remove();
});

$('#serviceForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    $.ajax({
        url: "{{ route('professional.requested_services.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status=='success') {
                toastr.success(response.message);
                form.reset();
                setTimeout(() => {
                    window.location.href = "{{ route('professional.requested_services.index') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
            }
        }
    });
});
</script>
@endsection
