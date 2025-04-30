@extends('admin.layouts.layout')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <h1 class="mb-4">Edit Why Choose Us Section</h1>

        <form action="{{ route('admin.whychoose.update', $whychoose->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="section_heading" class="form-label">Section Heading</label>
            <input type="text" name="section_heading" id="section_heading" class="form-control" value="{{ old('section_heading', $whychoose->section_heading) }}" required>
        </div>

        <div class="mb-3">
            <label for="section_sub_heading" class="form-label">Section Sub Heading</label>
            <input type="text" name="section_sub_heading" id="section_sub_heading" class="form-control" value="{{ old('section_sub_heading', $whychoose->section_sub_heading) }}" required>
        </div>

        <hr>
        <h4>Card 1</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card1_mini_heading" class="form-control" value="{{ old('card1_mini_heading', $whychoose->card1_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card1_heading" class="form-control" value="{{ old('card1_heading', $whychoose->card1_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card1_icon" class="form-control" value="{{ old('card1_icon', $whychoose->card1_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card1_description" class="form-control" value="{{ old('card1_description', $whychoose->card1_description) }}" required>
            </div>
        </div>

        <hr>
        <h4>Card 2</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card2_mini_heading" class="form-control" value="{{ old('card2_mini_heading', $whychoose->card2_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card2_heading" class="form-control" value="{{ old('card2_heading', $whychoose->card2_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card2_icon" class="form-control" value="{{ old('card2_icon', $whychoose->card2_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card2_description" class="form-control" value="{{ old('card2_description', $whychoose->card2_description) }}" required>
            </div>
        </div>

        <hr>
        <h4>Card 3</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card3_mini_heading" class="form-control" value="{{ old('card3_mini_heading', $whychoose->card3_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card3_heading" class="form-control" value="{{ old('card3_heading', $whychoose->card3_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card3_icon" class="form-control" value="{{ old('card3_icon', $whychoose->card3_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card3_description" class="form-control" value="{{ old('card3_description', $whychoose->card3_description) }}" required>
            </div>
        </div>

        <hr>
        <h4>Card 4</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card4_mini_heading" class="form-control" value="{{ old('card4_mini_heading', $whychoose->card4_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card4_heading" class="form-control" value="{{ old('card4_heading', $whychoose->card4_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card4_icon" class="form-control" value="{{ old('card4_icon', $whychoose->card4_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card4_description" class="form-control" value="{{ old('card4_description', $whychoose->card4_description) }}" required>
            </div>
        </div>

        <hr>
        <h4>Card 5</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card5_mini_heading" class="form-control" value="{{ old('card5_mini_heading', $whychoose->card5_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card5_heading" class="form-control" value="{{ old('card5_heading', $whychoose->card5_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card5_icon" class="form-control" value="{{ old('card5_icon', $whychoose->card5_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card5_description" class="form-control" value="{{ old('card5_description', $whychoose->card5_description) }}" required>
            </div>
        </div>

        <hr>
        <h4>Card 6</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Mini Heading</label>
                <input type="text" name="card6_mini_heading" class="form-control" value="{{ old('card6_mini_heading', $whychoose->card6_mini_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Heading</label>
                <input type="text" name="card6_heading" class="form-control" value="{{ old('card6_heading', $whychoose->card6_heading) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Icon</label>
                <input type="text" name="card6_icon" class="form-control" value="{{ old('card6_icon', $whychoose->card6_icon) }}" required>
            </div>
            <div class="col-md-3 mb-3">
                <label>Description</label>
                <input type="text" name="card6_description" class="form-control" value="{{ old('card6_description', $whychoose->card6_description) }}" required>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.whychoose.index') }}" class="btn btn-secondary">Cancel</a>
        </div>

        </form>
    </div>
</div>
@endsection
