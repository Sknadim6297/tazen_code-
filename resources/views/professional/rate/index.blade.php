@extends('professional.layout.layout')

@section('style')

@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">All Rates</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4>Rate List</h4>
                <div class="card-actions">
                    @if($rateCount < 4)
                    <a href="{{ route('professional.rate.create') }}" style="background-color: #0d67c7;color:white;padding:7px;border-radius:10px">Add Rate</a>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Session Type</th>
                            <th>No. of Sessions</th>
                            <th>Rate/Session (₹)</th>
                            <th>Final Rate (₹)</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rates as $rate)
                            <tr>
                                <td>{{ $rate->session_type }}</td>
                                <td>{{ $rate->num_sessions }}</td>
                                <td>₹{{ number_format($rate->rate_per_session, 2) }}</td>
                                <td>₹{{ number_format($rate->final_rate, 2) }}</td>
                                <td>{{ $rate->duration }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('professional.rate.edit', $rate->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>     
                                        <a href="javascript:void(0)" data-url="{{  route('professional.rate.destroy', $rate->id)  }}" class="btn btn-sm btn-outline-warning delete-item" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No rate details found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
