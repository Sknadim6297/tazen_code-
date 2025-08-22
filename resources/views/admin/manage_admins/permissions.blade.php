@extends('admin.layouts.layout')
@section('title', 'Admin Menu Permissions')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Menu Permissions for {{ $admin->name }}</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_admins.index') }}">Manage Administrators</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Menu Permissions</li>
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
                            Assign Menu Permissions
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

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.manage_admins.update_permissions', $admin->id) }}" method="POST">
                            @csrf
                            
                            <div class="alert alert-info mb-3">
                                <strong>Note:</strong> Selecting a parent menu will automatically grant access to all its child menus.
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-bold" for="selectAll">
                                        Select All Menus
                                    </label>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($menus as $menu)
                                            <tr>
                                                <td>
                                                    <strong>{{ $menu->display_name }}</strong>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input menu-checkbox" type="checkbox" 
                                                            id="menu_{{ $menu->id }}" 
                                                            name="menu_ids[]" 
                                                            value="{{ $menu->id }}" 
                                                            @if(in_array($menu->id, $adminMenuIds)) checked @endif>
                                                        <label class="form-check-label" for="menu_{{ $menu->id }}">
                                                            Allow
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if ($menu->children->count() > 0)
                                                @foreach ($menu->children as $childMenu)
                                                    <tr class="child-row">
                                                        <td class="ps-4">
                                                            ↳ {{ $childMenu->display_name }}
                                                        </td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input menu-checkbox child-checkbox" 
                                                                    type="checkbox" 
                                                                    id="menu_{{ $childMenu->id }}" 
                                                                    name="menu_ids[]" 
                                                                    value="{{ $childMenu->id }}" 
                                                                    data-parent="{{ $menu->id }}"
                                                                    @if(in_array($childMenu->id, $adminMenuIds)) checked @endif>
                                                                <label class="form-check-label" for="menu_{{ $childMenu->id }}">
                                                                    Allow
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @if ($childMenu->children->count() > 0)
                                                        @foreach ($childMenu->children as $grandChildMenu)
                                                            <tr class="grand-child-row">
                                                                <td class="ps-5">
                                                                    ↳↳ {{ $grandChildMenu->display_name }}
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input menu-checkbox grandchild-checkbox" 
                                                                            type="checkbox" 
                                                                            id="menu_{{ $grandChildMenu->id }}" 
                                                                            name="menu_ids[]" 
                                                                            value="{{ $grandChildMenu->id }}" 
                                                                            data-parent="{{ $childMenu->id }}"
                                                                            @if(in_array($grandChildMenu->id, $adminMenuIds)) checked @endif>
                                                                        <label class="form-check-label" for="menu_{{ $grandChildMenu->id }}">
                                                                            Allow
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('admin.manage_admins.index') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Permissions</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select All functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const menuCheckboxes = document.querySelectorAll('.menu-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            menuCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Check if all are selected initially
        function updateSelectAll() {
            const allChecked = Array.from(menuCheckboxes).every(checkbox => checkbox.checked);
            selectAllCheckbox.checked = allChecked;
        }

        // Parent-child relationship
        document.querySelectorAll('.menu-checkbox:not(.child-checkbox):not(.grandchild-checkbox)').forEach(parentCheckbox => {
            parentCheckbox.addEventListener('change', function() {
                const parentId = parentCheckbox.value;
                document.querySelectorAll(`.child-checkbox[data-parent="${parentId}"]`).forEach(childCheckbox => {
                    childCheckbox.checked = parentCheckbox.checked;
                    
                    // Also update grandchildren
                    const childId = childCheckbox.value;
                    document.querySelectorAll(`.grandchild-checkbox[data-parent="${childId}"]`).forEach(grandchildCheckbox => {
                        grandchildCheckbox.checked = childCheckbox.checked;
                    });
                });
                updateSelectAll();
            });
        });

        // Child-grandchild relationship
        document.querySelectorAll('.child-checkbox').forEach(childCheckbox => {
            childCheckbox.addEventListener('change', function() {
                const childId = childCheckbox.value;
                document.querySelectorAll(`.grandchild-checkbox[data-parent="${childId}"]`).forEach(grandchildCheckbox => {
                    grandchildCheckbox.checked = childCheckbox.checked;
                });
                
                // If child is unchecked, uncheck parent too
                if (!childCheckbox.checked) {
                    const parentId = childCheckbox.dataset.parent;
                    document.getElementById(`menu_${parentId}`).checked = false;
                }
                
                updateSelectAll();
            });
        });

        // Grandchild affects its parent
        document.querySelectorAll('.grandchild-checkbox').forEach(grandchildCheckbox => {
            grandchildCheckbox.addEventListener('change', function() {
                if (!grandchildCheckbox.checked) {
                    const parentId = grandchildCheckbox.dataset.parent;
                    document.getElementById(`menu_${parentId}`).checked = false;
                    
                    // Also uncheck the grandparent
                    const parentCheckbox = document.getElementById(`menu_${parentId}`);
                    const grandparentId = parentCheckbox.dataset.parent;
                    if (grandparentId) {
                        document.getElementById(`menu_${grandparentId}`).checked = false;
                    }
                }
                
                updateSelectAll();
            });
        });

        // Check for any changes on load
        menuCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectAll);
        });

        // Initialize the selectAll state
        updateSelectAll();
    });
</script>
@endpush
@endsection
