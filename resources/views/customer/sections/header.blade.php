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
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
            <div class="user-info">
                <h5>{{ Auth::guard('user')->user()->name }}</h5>
                <p>User</p>
            </div>
        </div>
    </div>
</div>