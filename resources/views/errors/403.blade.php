@extends('layouts.layout')
@section('styles')
<style>
    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(200deg, #fd7e1473,#f4cf2d73);
        padding: 20px;
    }
    
    .error-container {
        text-align: center;
        padding: 60px 40px;
        margin-top: 100px;
        max-width: 500px;
        width: 100%;
        position: relative;
    }
    
    .error-number {
        font-size: 180px;
        font-weight: 900;
        color: #fd7e14;
        margin: 0;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .error-title {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin: 20px 0 15px 0;
    }
    
    .error-message {
        font-size: 18px;
        color: #666;
        margin-bottom: 40px;
        line-height: 1.6;
    }
    
    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 30px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #fd7e14 0%, #e8650e 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(253, 126, 20, 0.4);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(253, 126, 20, 0.6);
        color: white;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: transparent;
        color: #fd7e14;
        padding: 12px 30px;
        border: 2px solid #fd7e14;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #fd7e14;
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .error-container {
            padding: 40px 20px;
        }
        
        .error-number {
            font-size: 120px;
        }
        
        .error-title {
            font-size: 24px;
        }
        
        .error-message {
            font-size: 16px;
        }
        
        .error-actions {
            flex-direction: column;
            align-items: center;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
            max-width: 250px;
        }
    }
</style>
@endsection

@section('content')
<main class="error-page">
    <div class="error-container">
        <h1 class="error-number">403</h1>
        <h2 class="error-title">Access Forbidden</h2>
        <p class="error-message">
            Sorry, you don't have permission to access this page. Please contact the administrator if you believe this is an error.
        </p>
        
        <div class="error-actions">
            <a href="{{ route('home') }}" class="btn-primary">
                <i class="fas fa-home"></i> Go Home
            </a>
            <a href="javascript:history.back()" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
</main>
@endsection
