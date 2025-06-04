@extends('professional.layout.layout')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h1>My Reviews</h1>
                </div>
                <div class="col-6 text-right">
                    <nav class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Reviews</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Rating Summary Cards -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="card overall-card">
                        <div class="card-body">
                            <h4 class="card-title">Overall Rating</h4>
                            <div class="rating-value">{{ number_format($averageRating, 1) }}</div>
                            <div class="star-container">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($averageRating))
                                        <i class="fas fa-star filled"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="review-count">Based on {{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Rating Distribution</h4>
                            @for($i = 5; $i >= 1; $i--)
                                <div class="rating-row">
                                    <div class="star-label">{{ $i }} {{ Str::plural('star', $i) }}</div>
                                    <div class="progress-container">
                                        @php $percentage = $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0; @endphp
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <div class="count-label">{{ $ratingCounts[$i] }}</div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Card -->
            <div class="card filter-card">
                <div class="card-body">
                    <form action="{{ route('professional.reviews.index') }}" method="GET" id="filter-form">
                        <div class="filter-grid">
                            <div class="filter-item">
                                <label>Date From</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="filter-item">
                                <label>Date To</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="filter-item">
                                <label>Rating</label>
                                <select name="rating">
                                    <option value="">All Ratings</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} {{ Str::plural('Star', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="filter-buttons">
                                <button type="submit" class="btn-primary">Filter</button>
                                <a href="{{ route('professional.reviews.index') }}" class="btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="card reviews-card">
                <div class="card-body">
                    <h4 class="card-title">All Reviews</h4>
                    
                    @if($reviews->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-star empty-icon"></i>
                            <h5>No reviews yet</h5>
                            <p>You haven't received any reviews that match your current filters.</p>
                        </div>
                    @else
                        <div class="reviews-list">
                            @foreach($reviews as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="user-info">
                                            <h5>{{ $review->user->name ?? 'Anonymous' }}</h5>
                                            <span class="date">{{ $review->created_at->format('F d, Y') }}</span>
                                        </div>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star filled"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="review-text">{{ $review->review_text }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-container">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Grid System */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    
    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-lg-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .col-lg-8 {
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    @media (max-width: 992px) {
        .col-lg-4, .col-lg-8 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
    
    .text-right {
        text-align: right;
    }

    /* Cards */
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }
    
    .card-title {
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
        font-weight: 500;
    }
    
    /* Breadcrumb */
    .breadcrumb-container {
        display: flex;
        justify-content: flex-end;
    }
    
    .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        padding: 0.5rem 1rem;
        margin-bottom: 1rem;
        list-style: none;
        background-color: #f0f0f0;
        border-radius: 0.25rem;
    }
    
    .breadcrumb-item {
        display: flex;
    }
    
    .breadcrumb-item + .breadcrumb-item {
        padding-left: 0.5rem;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        display: inline-block;
        padding-right: 0.5rem;
        color: #6c757d;
        content: "/";
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }

    /* Overall Rating Card */
    .overall-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    
    .rating-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: #f8ce0b;
        margin-bottom: 0.5rem;
    }
    
    .star-container {
        margin-bottom: 0.75rem;
    }
    
    .star-container i {
        font-size: 1.5rem;
        margin: 0 0.1rem;
        color: #f8ce0b;
    }
    
    .review-count {
        margin-bottom: 0;
        color: #6c757d;
    }
    
    /* Rating Distribution */
    .rating-row {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .star-label {
        flex: 0 0 60px;
    }
    
    .progress-container {
        flex: 1;
        height: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
        margin: 0 0.75rem;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        background-color: #f8ce0b;
        border-radius: 5px;
    }
    
    .count-label {
        flex: 0 0 40px;
        text-align: right;
    }
    
    /* Filter Section */
    .filter-card {
        margin-bottom: 1.5rem;
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 1rem;
    }
    
    @media (max-width: 992px) {
        .filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .filter-item {
        display: flex;
        flex-direction: column;
    }
    
    .filter-item label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .filter-item input,
    .filter-item select {
        padding: 0.5rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        width: 100%;
    }
    
    .filter-buttons {
        display: flex;
        align-items: flex-end;
    }
    
    .btn-primary,
    .btn-secondary {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    .btn-secondary {
        color: #fff;
        background-color: #6c757d;
        border: 1px solid #6c757d;
        text-decoration: none;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    
    /* Reviews List */
    .reviews-list {
        display: flex;
        flex-direction: column;
    }
    
    .review-item {
        border: 1px solid #e9ecef;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        background-color: #fff;
    }
    
    .review-item:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }
    
    .user-info h5 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .date {
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .rating i {
        color: #f8ce0b;
        margin-left: 0.1rem;
    }
    
    i.filled {
        color: #f8ce0b;
    }
    
    .review-text {
        margin-bottom: 0;
        line-height: 1.6;
    }
    
    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }
    
    .empty-state h5 {
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
        font-weight: 500;
    }
    
    .empty-state p {
        color: #6c757d;
        max-width: 400px;
        margin: 0 auto;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }
    
    /* Miscellaneous */
    .content-header {
        margin-bottom: 1.5rem;
    }
    
    h1 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
    }
    
    .content {
        padding: 0 1rem;
    }
    
    .container-fluid {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
</style>
@endsection