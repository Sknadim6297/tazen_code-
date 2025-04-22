@extends('customer.layout.layout')

@section('styles')

@endsection

@section('content')
 
<div class="row gy-4">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <p class="mb-2 text-muted">Basic Input:</p>
        <input type="text" class="form-control" id="input">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-label" class="form-label">Form Input With Label</label>
        <input type="text" class="form-control" id="input-label">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-placeholder" class="form-label">Form Input With Placeholder</label>
        <input type="text" class="form-control" id="input-placeholder" placeholder="Placeholder">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-text" class="form-label">Type Text</label>
        <input type="text" class="form-control" id="input-text" placeholder="Text">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-number" class="form-label">Type Number</label>
        <input type="number" class="form-control" id="input-number" placeholder="Number">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-password" class="form-label">Type Password</label>
        <input type="password" class="form-control" id="input-password" placeholder="Password">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-email" class="form-label">Type Email</label>
        <input type="email" class="form-control" id="input-email" placeholder="Email@xyz.com">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-tel" class="form-label">Type Tel</label>
        <input type="tel" class="form-control" id="input-tel" placeholder="+1100-2031-1233">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-date" class="form-label">Type Date</label>
        <input type="date" class="form-control" id="input-date">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-week" class="form-label">Type Week</label>
        <input type="week" class="form-control" id="input-week">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-month" class="form-label">Type Month</label>
        <input type="month" class="form-control" id="input-month">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-time" class="form-label">Type Time</label>
        <input type="time" class="form-control" id="input-time">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-datetime-local" class="form-label">Type datetime-local</label>
        <input type="datetime-local" class="form-control" id="input-datetime-local">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-search" class="form-label">Type Search</label>
        <input type="search" class="form-control" id="input-search" placeholder="Search">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-submit" class="form-label">Type Submit</label>
        <input type="submit" class="form-control" id="input-submit" value="Submit">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-reset" class="form-label">Type Reset</label>
        <input type="reset" class="form-control" id="input-reset">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-button" class="form-label">Type Button</label>
        <input type="button" class="form-control btn btn-primary" id="input-button"  value="Button">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <div class="col-xl-4">
                <label class="form-label">Type Color</label>
                <input class="form-control form-input-color" type="color" value="#136bd0">
            </div>
            <div class="col-xl-4">
                <div class="form-check">
                    <p class="mb-3 px-0 text-muted">Type Checkbox</p>
                    <input class="form-check-input ms-2" type="checkbox" value="" checked="">
                </div>
            </div>
            <div class="col-xl-3">
                <div class="form-check">
                    <p class="mb-3 px-0 text-muted">Type Radio</p>
                    <input class="form-check-input ms-2" type="radio" checked="">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-file" class="form-label">Type File</label>
        <input class="form-control" type="file" id="input-file">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label class="form-label">Type Url</label>
        <input class="form-control" type="url"  name="website" placeholder="http://example.com">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-disabled" class="form-label">Type Disabled</label>
        <input type="text" id="input-disabled" class="form-control" placeholder="Disabled input" disabled="">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-readonlytext" class="form-label">Input Readonly Text</label>
        <input type="text" readonly="" class="form-control-plaintext" id="input-readonlytext" value="email@example.com">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="disabled-readonlytext" class="form-label">Disabled Readonly Input</label>
        <input class="form-control" type="text" value="Disabled readonly input" id="disabled-readonlytext" aria-label="Disabled input example" disabled="" readonly="">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label class="form-label">Type Readonly Input</label>
        <input class="form-control" type="text" value="Readonly input here..." aria-label="readonly input example" readonly="">
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="text-area" class="form-label">Textarea</label>
        <textarea class="form-control" id="text-area" rows="1"></textarea>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <label for="input-DataList" class="form-label">Datalist example</label>
        <input class="form-control" list="datalistOptions" id="input-DataList" placeholder="Type to search...">
        <datalist id="datalistOptions">
            <option value="San Francisco">
            </option>
            <option value="New York">
            </option>
            <option value="Seattle">
            </option>
            <option value="Los Angeles">
            </option>
            <option value="Chicago">
            </option>
        </datalist>
    </div>
</div>
@endsection
