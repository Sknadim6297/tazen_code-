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
        <div class="header-icon">
            <i class="far fa-envelope"></i>
            <span class="badge">3</span>
        </div>
        <div class="header-icon">
            <i class="far fa-bell"></i>
            <span class="badge">5</span>
        </div>
        <div class="header-icon">
            <a href="{{ route('professional.logout') }}" class="btn btn-danger"><i class="fa-solid fa-power-off"></i></a>
            </div>
        <div class="user-profile">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
            @php
    $professional = Auth::guard('professional')->user();
@endphp

@if($professional)
    <div class="user-info">
        <h5>{{ $professional->name }}</h5>
        <p>Professional</p>
    </div>
@endif

        </div>
    </div>
</div>