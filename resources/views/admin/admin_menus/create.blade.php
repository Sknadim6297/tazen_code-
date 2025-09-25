@extends('admin.layouts.layout')
@section('title', 'Create Admin Menu')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Create Admin Menu</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin_menus.index') }}">Admin Menus</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Create New Admin Menu
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.admin_menus.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Menu Name (Internal) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    <small class="text-muted">Unique name used for identifying this menu (e.g. manage_admins)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="display_name" class="form-label">Display Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="display_name" name="display_name" value="{{ old('display_name') }}" required>
                                    <small class="text-muted">Name shown in the menu (e.g. Manage Admins)</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="route_name" class="form-label">Route Name</label>
                                    <input type="text" class="form-control" id="route_name" name="route_name" value="{{ old('route_name') }}">
                                    <small class="text-muted">The Laravel route name (e.g. admin.manage_admins.index)</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="icon" class="form-label">Icon</label>
                                    <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon') }}">
                                    <small class="text-muted">CSS class or SVG content for the menu icon</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="parent_id" class="form-label">Parent Menu</label>
                                    <select class="form-select" id="parent_id" name="parent_id">
                                        <option value="">None (Top Level Menu)</option>
                                        @foreach($parentMenus as $parentMenu)
                                            <option value="{{ $parentMenu->id }}" {{ old('parent_id') == $parentMenu->id ? 'selected' : '' }}>
                                                {{ $parentMenu->display_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="order" class="form-label">Display Order <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 0) }}" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('admin.admin_menus.index') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Menu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
