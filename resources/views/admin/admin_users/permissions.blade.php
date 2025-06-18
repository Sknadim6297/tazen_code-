@extends('admin.layouts.layout')
@section('content')
<!-- Start::row-1 -->
<div class="main-content app-content">
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    Menu Permissions for {{ $adminUser->name }}
                </div>
                <div>
                    <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back to Admin Users
                    </a>
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
                
                <form action="{{ route('admin.admin-users.permissions.update', $adminUser->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <p><strong>Role:</strong> {{ ucfirst($adminUser->role) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $adminUser->is_active ? 'success' : 'danger' }}">
                                    {{ $adminUser->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                            <p class="text-primary mb-4">Select the menus this admin should have access to:</p>
                            
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">Select All</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="deselectAll">Deselect All</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($parentMenus as $parentMenu)
                            @if($parentMenu->name !== 'admin_management') <!-- Hide admin management from permissions -->
                                <div class="col-lg-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-check">
                                                <input class="form-check-input parent-menu" type="checkbox" 
                                                    id="menu_{{ $parentMenu->id }}" 
                                                    name="menu_permissions[]" 
                                                    value="{{ $parentMenu->id }}"
                                                    {{ in_array($parentMenu->id, $adminMenuIds) ? 'checked' : '' }}
                                                    data-parent-id="{{ $parentMenu->id }}">
                                                <label class="form-check-label" for="menu_{{ $parentMenu->id }}">
                                                    <i class="{{ $parentMenu->icon }}"></i> <strong>{{ $parentMenu->display_name }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                        @if($parentMenu->children->count() > 0)
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($parentMenu->children as $childMenu)
                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input child-menu" type="checkbox" 
                                                                    id="menu_{{ $childMenu->id }}" 
                                                                    name="menu_permissions[]" 
                                                                    value="{{ $childMenu->id }}"
                                                                    data-parent-id="{{ $parentMenu->id }}"
                                                                    {{ in_array($childMenu->id, $adminMenuIds) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="menu_{{ $childMenu->id }}">
                                                                    {{ $childMenu->display_name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Save Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- End::row-1 -->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle child checkboxes when parent checkbox is clicked
        $('.parent-menu').change(function() {
            var parentId = $(this).data('parent-id');
            var checked = $(this).prop('checked');
            
            $('.child-menu[data-parent-id="' + parentId + '"]').prop('checked', checked);
        });
        
        // If all children are checked, check the parent
        $('.child-menu').change(function() {
            var parentId = $(this).data('parent-id');
            var allChecked = true;
            
            $('.child-menu[data-parent-id="' + parentId + '"]').each(function() {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false; // break the loop
                }
            });
            
            $('#menu_' + parentId).prop('checked', allChecked);
        });
        
        // Select all permissions
        $('#selectAll').click(function() {
            $('.parent-menu, .child-menu').prop('checked', true);
        });
        
        // Deselect all permissions
        $('#deselectAll').click(function() {
            $('.parent-menu, .child-menu').prop('checked', false);
        });
        
        // For each parent, check if all children are checked and update parent checkbox
        $('.parent-menu').each(function() {
            var parentId = $(this).data('parent-id');
            var allChecked = true;
            
            $('.child-menu[data-parent-id="' + parentId + '"]').each(function() {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false;
                }
            });
            
            $(this).prop('checked', allChecked);
        });
    });
</script>
@endsection