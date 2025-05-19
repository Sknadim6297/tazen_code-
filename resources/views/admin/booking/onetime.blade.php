@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">One Time Booking</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">One Time </a></li>
                        </ol>
                    </nav>
                </div>
            </div>
    <form action="{{ route('admin.onetime') }}" method="GET" class="d-flex gap-2">
        
    <div class="col-md-3">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Select Status --</option>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>
     <div class="col-md-4">
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control"  placeholder="Choose Start Date" name="start_date" id="start_date">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control"  placeholder="Choose End Date" name="end_date" id="end_date">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
</div>
        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total One Time Bookings:
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Customer Name</th>
                                        <th>Professional Name</th>
                                        <th>Service Required</th>
                                      <th>Status</th>
                                        <th>Service Date On</th>
                                        <th>Service Time</th>
                                        <th>Add link for the Service</th>
                                        <th>Paid Amount</th>
                                        <th>Professional document</th>
                                        <th>Customer Document</th>
                                        <th>Telecaller Remarks</th>
                                         <th>Professional Remarks to customer</th>
                                                   <th>Admin remarks to professional</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($bookings as $key => $booking)
                                      @php  
                                    //   print_r($booking->timedates);
                // Get earliest upcoming date
                $earliestTimedate = $booking->timedates && $booking->timedates->count() > 0 
                    ? $booking->timedates
                        ->filter(fn($td) => \Carbon\Carbon::parse($td->date)->isFuture())
                        ->sortBy('date')
                        ->first()
                    : null;

                $completedSessions = 0;
                $pendingSessions = 0;

                if ($booking->timedates && $booking->timedates->count() > 0) {
                    foreach ($booking->timedates as $td) {
                        $slots = explode(',', $td->time_slot);
                        if ($td->status === 'completed') {
                            $completedSessions += count($slots);
                        } else {
                            $pendingSessions += count($slots);
                        }
                    }
                }
            @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $booking->customer_name}}
                    <br>
                    ({{ $booking->customer_phone }})
                </td>
                <td>{{ $booking->professional->name }}
                    <br>
                    ({{ $booking->professional->phone }})
                </td>
                           <td>{{ $booking->service_name }}</td>
                     <td>
    {{ $booking->timedates->first()?->status ?? '-' }}
</td>

                <td>{{ $earliestTimedate ? \Carbon\Carbon::parse($earliestTimedate->date)->format('d M Y') : '-' }}</td>

                <td>{!! $earliestTimedate ? str_replace(',', '<br>', $earliestTimedate->time_slot) : '-' !!}</td>
                                            <td>
                                                <form action="{{ route('admin.add-link', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input type="url" name="meeting_link" class="form-control" value="{{ $booking->meeting_link }}" placeholder="Add Link" required  style="width: 350px;">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                       <td>Null</td>
 <td>
    @if(!empty($booking->professional_documents))
        @foreach(explode(',', $booking->professional_documents) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
<td>
    @if(!empty($booking->customer_document))
        @foreach(explode(',', $booking->customer_document) as $doc)
            <a href="{{ asset('storage/' . $doc) }}" target="_blank"
               class="d-inline-flex justify-content-center align-items-center me-2 mb-1"
               style="width: 40px; height: 40px; border: 1px solid #ddd; border-radius: 5px;">
                <i class="bi bi-download fs-4 text-primary"></i>
            </a>
        @endforeach
    @else
        No Document
    @endif
</td>
    <td>
                                                <form action="{{ route('admin.add-remarks', ['id' => $booking->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="d-flex">
                                                        <input id="marks" class="form-control" type="text" name="remarks" placeholder="Remarks" style="width: 350px;" value="{{ $booking->remarks }}">
                                                        <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                                                    </div>
                                                </form>
                                            </td>
                                  <td>
                  @if($booking->timedates->isNotEmpty())
                 @foreach($booking->timedates as $timedate)
                 {{ $timedate->remarks ?? '-' }}<br>
                    @endforeach
                @else
                     -
              @endif
          </td>
           <td>
    <form action="{{ route('admin.professional-add-remarks', ['id' => $booking->id]) }}" method="POST">
        @csrf
        <div class="d-flex">
            <input id="remarks_for_professional" class="form-control" type="text" name="remarks_for_professional" placeholder="Remarks for Professional" style="width: 350px;" value="{{ $booking->remarks_for_professional }}">
            <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
        </div>
    </form>
</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            

                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->


    </div>
</div>
@endsection