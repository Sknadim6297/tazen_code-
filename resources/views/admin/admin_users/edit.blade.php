@extends('admin.layouts.layout')

@section('title', 'Edit Admin User')

@section('content')
<!-- Start::row-1 -->
<div class="main-content app-content">
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title">
                    Edit Admin User
                </div>
                <div>
                    <a href="{{ route('admin.admin-users.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line me-1"></i> Back to List
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
                
                <form action="{{ route('admin.admin-users.update', $adminUser->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $adminUser->name) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $adminUser->email) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password (leave empty to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="super_admin" {{ (old('role', $adminUser->role) == 'super_admin') ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ (old('role', $adminUser->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ (old('is_active', $adminUser->is_active) == 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    
                    @if(old('role', $adminUser->role) !== 'super_admin')
                    <div class="row mt-4" id="menu-permissions-section">
                        <div class="col-12 mb-3">
                            <h4>Menu Permissions</h4>
                            <p class="text-muted">Select which menus this admin can access:</p>
                        </div>

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
                    @endif
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Update Admin User
                        </button>
                        @if($adminUser->role !== 'super_admin')
                            <a href="{{ route('admin.admin-users.permissions', $adminUser->id) }}" class="btn btn-info ms-2">
                                <i class="ri-lock-line me-1"></i> Manage Menu Permissions
                            </a>
                        @endif
                    </div>
                </form>
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
        
        // Show/hide permissions section based on role selection
        $('#role').change(function() {
            if ($(this).val() === 'super_admin') {
                $('#menu-permissions-section').hide();
            } else {
                $('#menu-permissions-section').show();
            }
        });
        
        // Initial check
        if ($('#role').val() === 'super_admin') {
            $('#menu-permissions-section').hide();
        }
    });
</script>
@endsection