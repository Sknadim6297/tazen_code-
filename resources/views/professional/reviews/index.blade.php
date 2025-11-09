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

    .reviews-page {
        width: 100%;
        padding: 2.6rem 1.45rem 3.6rem;
    }

    .reviews-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .reviews-hero {
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

    .reviews-hero::before,
    .reviews-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .reviews-hero::before {
        width: 340px;
        height: 340px;
        top: -46%;
        right: -12%;
        background: rgba(79, 70, 229, 0.2);
    }

    .reviews-hero::after {
        width: 220px;
        height: 220px;
        bottom: -42%;
        left: -10%;
        background: rgba(14, 165, 233, 0.18);
    }

    .reviews-hero > * { position: relative; z-index: 1; }

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

    .rating-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.2rem;
    }

    .summary-card,
    .distribution-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 1.9rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
    }

    .summary-card h4,
    .distribution-card h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .overall-score {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.65rem;
    }

    .overall-score .score {
        font-size: 2.6rem;
        font-weight: 700;
        color: #fb923c;
    }

    .star-row {
        display: inline-flex;
        gap: 0.25rem;
        color: #fbbf24;
        font-size: 1.2rem;
    }

    .review-count {
        font-size: 0.85rem;
        color: var(--muted);
    }

    .distribution-list {
        display: flex;
        flex-direction: column;
        gap: 0.7rem;
    }

    .distribution-item {
        display: grid;
        grid-template-columns: 80px 1fr 50px;
        align-items: center;
        gap: 0.65rem;
    }

    .distribution-item .progress {
        height: 10px;
        background: rgba(226, 232, 240, 0.8);
        border-radius: 999px;
        overflow: hidden;
    }

    .distribution-item .progress-bar {
        height: 100%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: 999px;
    }

    .filters-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 1.9rem 2.1rem;
    }

    .filters-card form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.2rem;
        align-items: end;
    }

    .filters-card label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 0.4rem;
    }

    .filters-card input,
    .filters-card select {
        border-radius: 14px;
        border: 1px solid rgba(148, 163, 184, 0.35);
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .filters-card input:focus,
    .filters-card select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        outline: none;
    }

    .filter-actions {
        display: inline-flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .btn-primary,
    .btn-neutral {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        border-radius: 999px;
        border: none;
        padding: 0.8rem 1.6rem;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #ffffff;
        box-shadow: 0 18px 40px rgba(79, 70, 229, 0.2);
    }

    .btn-neutral {
        background: rgba(148, 163, 184, 0.18);
        color: #0f172a;
        border: 1px solid rgba(148, 163, 184, 0.35);
    }

    .btn-primary:hover,
    .btn-neutral:hover { transform: translateY(-1px); }

    .reviews-card {
        background: var(--card-bg);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 48px rgba(15, 23, 42, 0.14);
        padding: 1.9rem 2.1rem;
        display: flex;
        flex-direction: column;
        gap: 1.4rem;
    }

    .reviews-card h4 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .review-item {
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 18px;
        padding: 1.2rem 1.4rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        background: rgba(248, 250, 252, 0.8);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .review-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .user-info h5 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
    }

    .user-info .date {
        font-size: 0.82rem;
        color: var(--muted);
    }

    .review-rating { color: #fbbf24; }

    .review-text {
        margin: 0;
        color: #0f172a;
        line-height: 1.6;
        font-size: 0.93rem;
    }

    .empty-state {
        text-align: center;
        padding: 3.2rem 1.6rem;
        border-radius: 20px;
        border: 1px dashed rgba(79, 70, 229, 0.25);
        background: rgba(79, 70, 229, 0.08);
        color: var(--muted);
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        align-items: center;
    }

    .empty-state i {
        font-size: 2.8rem;
        color: var(--primary);
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 1.4rem;
    }

    @media (max-width: 768px) {
        .reviews-page { padding: 2.2rem 1rem 3.2rem; }
        .reviews-hero { padding: 1.75rem 1.6rem; }
        .filters-card { padding: 1.7rem 1.5rem; }
        .reviews-card { padding: 1.7rem 1.5rem; }
        .review-item { padding: 1rem 1.1rem; }
    }
</style>
@endsection

@section('content')
<div class="reviews-page">
    <div class="reviews-shell">
        <section class="reviews-hero">
            <div class="hero-meta">
                <span class="hero-eyebrow"><i class="fas fa-star"></i>Reviews</span>
                <h1>My Reviews</h1>
                <ul class="hero-breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                    <li class="active" aria-current="page">My Reviews</li>
                </ul>
            </div>
            <div class="status-pill">
                <i class="fas fa-user-check"></i>
                {{ $totalReviews }} {{ Str::plural('Review', $totalReviews) }}
            </div>
        </section>

        <section class="rating-summary">
            <article class="summary-card">
                <h4>Overall Rating</h4>
                <div class="overall-score">
                    <div class="score">{{ number_format($averageRating, 1) }}</div>
                    <div class="star-row">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($averageRating) ? '' : '-half-alt' }}" style="color: {{ $i <= round($averageRating) ? '#f59e0b' : '#e2e8f0' }};"></i>
                        @endfor
                    </div>
                    <span class="review-count">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</span>
                </div>
            </article>
            <article class="distribution-card">
                <h4>Rating Breakdown</h4>
                <div class="distribution-list">
                    @for($i = 5; $i >= 1; $i--)
                        @php $percentage = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0; @endphp
                        <div class="distribution-item">
                            <span>{{ $i }} {{ Str::plural('Star', $i) }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span>{{ $ratingCounts[$i] }}</span>
                        </div>
                    @endfor
                </div>
            </article>
        </section>

        <section class="filters-card">
            <form action="{{ route('professional.reviews.index') }}" method="GET" id="filter-form">
                <div class="filter-item">
                    <label for="start_date">Date From</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="filter-item">
                    <label for="end_date">Date To</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="filter-item">
                    <label for="rating">Rating</label>
                    <select id="rating" name="rating">
                        <option value="">All Ratings</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} {{ Str::plural('Star', $i) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-filter"></i>
                        Filter
                    </button>
                    <a href="{{ route('professional.reviews.index') }}" class="btn-neutral">
                        <i class="fas fa-undo"></i>
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="reviews-card">
            <h4>All Reviews</h4>
            @if($reviews->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-star"></i>
                    <h5>No reviews yet</h5>
                    <p>You haven't received any reviews that match your current filters.</p>
                </div>
            @else
                <div class="reviews-list">
                    @foreach($reviews as $review)
                        <article class="review-item">
                            <header class="review-header">
                                <div class="user-info">
                                    <h5>{{ $review->user->name ?? 'Anonymous' }}</h5>
                                    <span class="date">{{ $review->created_at->format('F d, Y') }}</span>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#f59e0b' : '#e2e8f0' }};"></i>
                                    @endfor
                                </div>
                            </header>
                            <p class="review-text">{{ $review->review_text }}</p>
                        </article>
                    @endforeach
                </div>
                <div class="pagination-container">
                    {{ $reviews->links() }}
                </div>
            @endif
        </section>
    </div>
</div>
@endsection