@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">MCQ Answers</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="mcqTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Service</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mcqAnswers as $answer)
                            <tr>
                                <td>{{ $answer->id }}</td>
                                <td>{{ $answer->user->name ?? 'N/A' }}</td>
                                <td>{{ $answer->service->name ?? 'N/A' }}</td>
                                <td>{{ $answer->question->question ?? 'N/A' }}</td>
                                <td>{{ $answer->answer }}</td>
                                <td>{{ $answer->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
</div>
<!-- /.container-fluid -->
@endsection

@section('scripts')
<script>
    $(function () {
        $("#mcqTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#mcqTable_wrapper .col-md-6:eq(0)');
    });
</script>
@endsection 