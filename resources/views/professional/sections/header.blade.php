@php
    use App\Models\Profile;
    use Illuminate\Support\Facades\Auth;
    $professional = Auth::guard('professional')->user();
    $profile = $professional ? Profile::where('professional_id', $professional->id)->first() : null;
@endphp

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
        @if($professional)
            <div class="header-icon logout">
                <a href="{{ route('professional.logout') }}" class="btn-logout" title="Logout">
                    <i class="fas fa-power-off"></i>
                </a>
            </div>

            <div class="user-profile-wrapper">
                <div class="user-profile">
                    <img src="{{ $profile->photo ? asset($profile->photo) : asset('default-avatar.png') }}" alt="User">
                </div>
                
                <div class="user-info">
                    <h5>{{ $professional->name }}</h5>
                    <p>Professional</p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 10px 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 999;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.toggle-sidebar i {
    font-size: 20px;
    cursor: pointer;
}

.search-box {
    display: flex;
    align-items: center;
    background: #f1f1f1;
    padding: 6px 10px;
    border-radius: 20px;
}

.search-box i {
    color: #999;
}

.search-box input {
    border: none;
    background: transparent;
    margin-left: 5px;
    outline: none;
    padding: 5px;
    font-size: 14px;
    width: 180px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-icon {
    position: relative;
    font-size: 18px;
    cursor: pointer;
    color: #333;
}

.header-icon .badge {
    position: absolute;
    top: -5px;
    right: -10px;
    background: red;
    color: #fff;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
}

.header-icon.logout .btn-logout {
    color: red;
    font-size: 18px;
}

.user-profile-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-profile img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ccc;
}

.user-info h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.user-info p {  
    margin: 0;
    font-size: 12px;
    color: #666;
}

/* Responsive */
@media (max-width: 768px) {
    .search-box input {
        width: 100px;
    }

    .user-info h5 {
        font-size: 14px;
    }

    .user-profile img {
        width: 35px;
        height: 35px;
    }

    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .header-left, .header-right {
        flex-wrap: wrap;
    }
}

</style>
