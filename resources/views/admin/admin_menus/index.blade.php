@extends('admin.layouts.layout')
@section('title', 'Manage Admin Menus')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Admin Menus</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Admin Menus</li>
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
                            Admin Menus List
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            <form action="{{ route('admin.admin_menus.sync') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    <i class="ri-refresh-line me-1"></i> Sync from Sidebar
                                </button>
                            </form>
                            <a href="{{ route('admin.admin_menus.create') }}" class="btn btn-primary">
                                <i class="ri-add-line me-1"></i> Add New Menu
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Menu Structure View -->
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-3">Menu Hierarchy</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Main Menu</th>
                                            <th>Sub Menus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($parentMenus as $parentMenu)
                                        <tr>
                                            <td class="fw-bold" style="width: 25%;">
                                                {{ $parentMenu->display_name }}
                                                <br>
                                                <small class="text-muted">({{ $parentMenu->name }})</small>
                                                <div class="mt-2">
                                                    <a href="{{ route('admin.admin_menus.edit', $parentMenu->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="ri-pencil-line"></i> Edit
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                @if(count($parentMenu->children) > 0)
                                                    <div class="row">
                                                        @foreach($parentMenu->children as $child)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="border rounded p-2">
                                                                    <strong>{{ $child->display_name }}</strong>
                                                                    <br>
                                                                    <small class="text-muted">({{ $child->name }})</small>
                                                                    <div class="mt-2">
                                                                        <a href="{{ route('admin.admin_menus.edit', $child->id) }}" class="btn btn-sm btn-outline-primary">
                                                                            <i class="ri-pencil-line"></i> Edit
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="text-muted">No submenus</div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- List All Menus -->
                        <h5 class="fw-semibold mb-3">All Menus (Flat View)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-dark">
                                        <th>ID</th>
                                        <th>Name (Key)</th>
                                        <th>Display Name</th>
                                        <th>Route</th>
                                        <th>Parent</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allMenus as $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->display_name }}</td>
                                        <td>{{ $menu->route_name ?? '-' }}</td>
                                        <td>
                                            @if($menu->parent)
                                                <span class="badge bg-info">{{ $menu->parent->display_name }}</span>
                                                <small class="text-muted d-block">({{ $menu->parent->name }})</small>
                                            @else
                                                <span class="badge bg-secondary">Top Level</span>
                                            @endif
                                        </td>
                                        <td>{{ $menu->order }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.admin_menus.edit', $menu->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="ri-pencil-line"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.admin_menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger ms-1">
                                                        <i class="ri-delete-bin-line"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No menus found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
