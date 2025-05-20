<div class="header">
    <div class="header-left">
        <div class="toggle-sidebar">
            <i class="fas fa-bars"></i>
        </div>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search...">
        </div>
    </div>

    <div class="header-right">

        <div class="header-icon logout">
                <a href="{{ route('user.logout') }}" class="btn-logout" title="Logout">
                    <i class="fas fa-power-off"></i>
                </a>
            </div>
        <div class="user-profile">
            @php
                $profile = Auth::guard('user')->user()->customerProfile;
            @endphp
            <img 
                src="{{ $profile && $profile->profile_image ? asset($profile->profile_image) : asset('default-avatar.png') }}" 
                alt="User"
                onerror="this.onerror=null;this.src='{{ asset('default-avatar.png') }}';"
            />
            <div class="user-info">
                <h5>{{ Auth::guard('user')->user()->name }}</h5>
                <p>User</p>
            </div>
        </div>
    </div>
</div>