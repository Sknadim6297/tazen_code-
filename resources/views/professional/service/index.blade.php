@extends('professional.layout.layout')

@section('styles')
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

    .services-index-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .services-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .services-hero {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.4rem;
        padding: 2rem 2.4rem;
        border-radius: 28px;
        border: 1px solid rgba(79, 70, 229, 0.18);
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.12), rgba(14, 165, 233, 0.16));
        position: relative;
        overflow: hidden;
        box-shadow: 0 24px 54px rgba(79, 70, 229, 0.16);
    }

    .services-hero::before,
    .services-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .services-hero::before {
        width: 320px;
        height: 320px;
        top: -45%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .services-hero::after {
        width: 220px;
        height: 220px;
        bottom: -40%;
        left: -10%;
        background: rgba(59, 130, 246, 0.18);
    }

    .services-hero > * { position: relative; z-index: 1; }

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

    .services-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        overflow: hidden;
    }

    .services-card__head {
        padding: 1.7rem 2.1rem 1.2rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.22);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .services-card__head h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .services-card__head a {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        padding: 0.75rem 1.35rem;
        font-weight: 600;
        font-size: 0.88rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        text-decoration: none;
        box-shadow: 0 18px 38px rgba(79, 70, 229, 0.22);
        transition: transform 0.2s ease;
    }

    .services-card__head a:hover { transform: translateY(-1px); }

    .services-card__body {
        padding: 2.1rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.6rem;
    }

    .table-wrapper {
        border-radius: 18px;
        border: 1px solid rgba(226, 232, 240, 0.85);
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        min-width: 980px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.92rem;
    }

    .data-table thead th {
        background: rgba(79, 70, 229, 0.08);
        padding: 0.95rem 1rem;
        text-align: center;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #0f172a;
    }

    .data-table tbody td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        background: #ffffff;
        color: #0f172a;
        vertical-align: top;
    }

    .data-table tbody tr:hover { background: rgba(226, 232, 240, 0.35); }
    .data-table thead th:first-child,
    .data-table tbody td:first-child { text-align: left; }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    .badge-info { background: rgba(79, 70, 229, 0.16); color: #4338ca; }
    .badge-success { background: rgba(34, 197, 94, 0.18); color: #15803d; }

    .actions-cell { white-space: nowrap; text-align: center; }
    .actions-cell .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.55rem 1rem;
        border-radius: 12px;
        border: none;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .action-btn.edit { background: rgba(14, 165, 233, 0.18); color: #0c4a6e; }
    .action-btn.delete { background: rgba(248, 113, 113, 0.18); color: #b91c1c; }
    .action-btn:hover { transform: translateY(-1px); }

    .empty-state {
        text-align: center;
        padding: 3rem 1.6rem;
        border-radius: 20px;
        border: 1px dashed rgba(79, 70, 229, 0.24);
        background: rgba(79, 70, 229, 0.08);
        color: var(--muted);
    }

    @media (max-width: 768px) {
        .services-index-page { padding: 2.2rem 1rem 3.2rem; }
        .services-hero { padding: 1.75rem 1.6rem; }
        .services-card__body { padding: 1.7rem 1.6rem; }
        .data-table { min-width: 720px; }
    }
</style>
@endsection

@section('content')
<div class="services-index-page">
    <div class="services-shell">
        <section class="services-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-briefcase"></i>Services</span>
                <h1>All Services</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">All Services</li>
                </ul>
            </div>
            @if(count($services) == 0)
                <a href="{{ route('professional.service.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    Add Service
                </a>
            @else
                <div class="alert alert-info mb-0" style="background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.3); color: #0369a1; border-radius: 12px; padding: 0.75rem 1rem;">
                    <i class="fas fa-info-circle"></i> You can only add one service. Edit your existing service below.
                </div>
            @endif
        </section>

        <section class="services-card">
            <header class="services-card__head">
                <h2>Service List</h2>
            </header>
            <div class="services-card__body">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Service Category</th>
                                <th>Sub-Services</th>
                                <th>Session Type</th>
                                <th>Tags</th>
                                <th>Client Requirements</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td data-label="Service Category">{{ $service->service->name }}</td>
                                    <td data-label="Sub-Services">
                                        @if($service->subServices->count() > 0)
                                            @foreach($service->subServices as $subService)
                                                <span class="badge badge-info">{{ $subService->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted" style="font-style:italic;">No specific sub-services</span>
                                        @endif
                                    </td>
                                    <td data-label="Session Type">
                                        <span class="badge badge-success">Online Session</span>
                                    </td>
                                    <td data-label="Tags">{{ $service->tags }}</td>
                                    <td data-label="Client Requirements">{{ $service->requirements }}</td>
                                    <td data-label="Actions" class="actions-cell">
                                        <div style="display:flex; gap:0.6rem; justify-content:center;">
                                            <a href="{{ route('professional.service.edit', $service->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-url="{{ route('professional.service.destroy', $service->id) }}" class="action-btn delete delete-item" title="Delete">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-info-circle"></i>
                                            <p>No services added yet. Click "Add Service" button above to create your service.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).on('click', '.delete-item', function(e) {
    e.preventDefault();
    const url = $(this).data('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.message || 'Service has been deleted.', 'success')
                            .then(() => window.location.reload());
                    } else {
                        Swal.fire('Error!', response.message || 'Failed to delete service.', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', xhr.responseJSON?.message || 'An error occurred while deleting the service.', 'error');
                }
            });
        }
    });
});
</script>
@endsection
