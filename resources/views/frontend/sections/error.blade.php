@extends('layouts.layout')
@section('styles')
<style>
    .error-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(200deg, #2d90f473,#f4cf2d73);
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
    
    @keyframes shimmer {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    
    .error-number {
        font-size: 180px;
        font-weight: 900;
        color: #667eea;
        margin: 0;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        color: white;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: transparent;
        color: #667eea;
        padding: 12px 30px;
        border: 2px solid #667eea;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #667eea;
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
        <h1 class="error-number">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-message">
            Oops! The page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
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