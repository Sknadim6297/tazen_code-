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

    .requested-services-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .requested-services-shell {
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
        width: 340px;
        height: 340px;
        top: -46%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .services-hero::after {
        width: 220px;
        height: 220px;
        bottom: -42%;
        left: -10%;
        background: rgba(14, 165, 233, 0.18);
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
        text-transform: uppercase;
        letter-spacing: 0.12em;
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
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
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
        border: 1px solid rgba(226, 232, 240, 0.85);
        border-radius: 18px;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .data-table {
        width: 100%;
        min-width: 980px;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.9rem;
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
        padding: 0.8rem 1rem;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        background: #ffffff;
        color: #0f172a;
        vertical-align: top;
    }

    .data-table tbody tr:hover { background: rgba(226, 232, 240, 0.35); }
    .data-table thead th:first-child,
    .data-table tbody td:first-child { text-align: left; }

    .service-list { display: flex; flex-direction: column; gap: 0.35rem; }
    .service-list div { font-size: 0.88rem; color: #0f172a; }

    .price-list { display: flex; flex-direction: column; gap: 0.35rem; color: #0f172a; font-weight: 600; }

    .education-list { display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.88rem; color: #0f172a; }

    .actions-cell {
        white-space: nowrap;
        text-align: center;
    }

    .actions-cell .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.55rem 0.95rem;
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

    .empty-state p { margin-top: 0.5rem; }

    @media (max-width: 768px) {
        .requested-services-page { padding: 2.2rem 1rem 3.2rem; }
        .services-hero { padding: 1.75rem 1.6rem; }
        .services-card__body { padding: 1.7rem 1.6rem; }
        .data-table { min-width: 720px; }
    }
</style>
@endsection

@section('content')
<div class="requested-services-page">
    <div class="requested-services-shell">
        <section class="services-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-clipboard-list"></i>Information</span>
                <h1>Other Information</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Home</a></li>
                    <li class="active" aria-current="page">Other Information</li>
                </ul>
            </div>
            <div>
                @if($serviceCount < 1)
                    <a href="{{ route('professional.requested_services.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        Add Information
                    </a>
                @endif
            </div>
        </section>

        <section class="services-card">
            <header class="services-card__head">
                <h2>Other Information List</h2>
                @if($serviceCount < 1)
                    <a href="{{ route('professional.requested_services.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        Add Information
                    </a>
                @endif
            </header>
            <div class="services-card__body">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Heading</th>
                                <th>Requested Services</th>
                                <th>Prices</th>
                                <th>Education Statement</th>
                                <th>Education</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requestedServices as $service)
                                @php
                                    $servicesList = json_decode($service->requested_service, true) ?? [];
                                    $pricesList = json_decode($service->price, true) ?? [];
                                    $educationList = json_decode($service->education, true) ?? [];
                                @endphp
                                <tr>
                                    <td>{{ $service->sub_heading }}</td>
                                    <td>
                                        <div class="service-list">
                                            @foreach($servicesList as $item)
                                                <div>{{ $item ?? '-' }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-list">
                                            @foreach($pricesList as $price)
                                                <div>₹{{ number_format((float) $price, 2) }}</div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $service->education_statement }}</td>
                                    <td>
                                        <div class="education-list">
                                            @if(is_array($educationList) && isset($educationList['college_name']))
                                                @foreach($educationList['college_name'] as $index => $college)
                                                    <div>{{ $college ?? '-' }} - {{ $educationList['degree'][$index] ?? '-' }}</div>
                                                @endforeach
                                            @else
                                                <div>-</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="actions-cell">
                                        <a href="{{ route('professional.requested_services.edit', $service->id) }}" class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <a href="javascript:void(0);"
                                           data-url="{{ route('professional.requested_services.destroy', $service->id) }}"
                                           data-id="{{ $service->id }}"
                                           class="action-btn delete delete-item">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-info-circle"></i>
                                            <h5>No data found</h5>
                                            <p>Once you add information, the list will appear here.</p>
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