@extends('professional.layout.layout')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --secondary: #0ea5e9;
        --accent: #22c55e;
        --warning: #f97316;
        --danger: #ef4444;
        --muted: #64748b;
        --text-dark: #0f172a;
        --text-light: #94a3b8;
        --page-bg: #f4f6fb;
        --surface: #ffffff;
        --border-color: rgba(148, 163, 184, 0.22);
        --border-strong: rgba(79, 70, 229, 0.24);
        --shadow-sm: 0 6px 12px rgba(15, 23, 42, 0.08);
        --shadow-md: 0 18px 36px rgba(15, 23, 42, 0.1);
        --shadow-lg: 0 32px 64px rgba(15, 23, 42, 0.14);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        --border-radius: 16px;
        /* legacy tokens */
        --primary-color: var(--primary);
        --primary-hover: var(--primary-dark);
        --secondary-color: var(--text-dark);
        --text-color: var(--text-dark);
        --light-text: var(--text-light);
        --bg-color: var(--page-bg);
        --card-bg: var(--surface);
        --success-color: var(--accent);
        --warning-color: var(--warning);
        --danger-color: var(--danger);
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        color: var(--text-color);
        background-color: var(--bg-color);
    }
    
    /* Content Wrapper */
    .content-wrapper {
        padding: 2rem;
        background-color: rgb(240 249 255);
        min-height: calc(100vh - 60px);
        transition: var(--transition);
    }

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .page-title h3::after {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 40px;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 2px;
    }

   
    /* Breadcrumb */
    .breadcrumb {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 10px;
        font-size: 0.85rem;
        color: var(--light-text);
        margin: 0;
    }

    .breadcrumb li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb li:not(:last-child)::after {
        content: "/";
        margin-left: 10px;
        color: #bdc3c7;
    }

    .breadcrumb li.active {
        font-weight: 600;
        color: var(--secondary-color);
    }

    /* Form Card */
    .add-profile-form {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid var(--border-color);
    }

    .add-profile-form:hover {
        box-shadow: var(--shadow-lg);
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
        font-size: 0.9rem;
        transition: var(--transition);
    }

    /* Input Fields */
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
        transition: var(--transition);
        background-color: var(--card-bg);
        color: var(--text-color);
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
    }

    input[type="text"]::placeholder,
    input[type="email"]::placeholder,
    input[type="tel"]::placeholder,
    input[type="number"]::placeholder,
    textarea::placeholder {
        color: #aab2bd;
    }

    /* File Upload Styling */
    input[type="file"] {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px dashed var(--border-color);
        border-radius: var(--border-radius);
        background-color: rgba(52, 152, 219, 0.03);
        font-size: 0.9rem;
        cursor: pointer;
        transition: var(--transition);
    }

    input[type="file"]:hover {
        border-color: var(--primary-color);
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Custom file input */
    .file-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    /* Image Preview */
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview img {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        max-width: 100px;
        object-fit: cover;
        border: 2px solid transparent;
    }

    .image-preview img:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .image-preview a {
        display: inline-block;
        padding: 5px 10px;
        background-color: rgba(52, 152, 219, 0.1);
        color: var(--primary-color);
        border-radius: var(--border-radius);
        font-size: 0.8rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .image-preview a:hover {
        background-color: rgba(52, 152, 219, 0.2);
    }

    /* Grid Layout */
    .form-group.col-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .form-group.col-full {
        width: 100%;
    }

    /* Button */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        padding: 0.85rem 1.5rem;
        color: white;
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 10px rgba(52, 152, 219, 0.3);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary i {
        font-size: 0.9rem;
    }

    /* Button Animation */
    .btn-primary::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease-out, height 0.6s ease-out;
    }

    .btn-primary:hover::before {
        width: 300px;
        height: 300px;
    }

    /* Form Sections */
    .form-section {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-section:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    /* Loading State */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: calc(50% - 8px);
        left: calc(50% - 8px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: rotate 0.8s linear infinite;
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    /* Form Feedback / Validation */
    .form-control-feedback {
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: none;
    }

    .is-invalid {
        border-color: var(--danger-color) !important;
    }

    .is-invalid + .form-control-feedback {
        display: block;
        color: var(--danger-color);
    }

    .is-valid {
        border-color: var(--success-color) !important;
    }

    .is-valid + .form-control-feedback {
        display: block;
        color: var(--success-color);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease forwards;
    }

    /* Form Field Focus Effect */
    .form-group:has(input:focus) label,
    .form-group:has(textarea:focus) label {
        color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .content-wrapper {
            padding: 1.5rem;
        }
        
        .add-profile-form {
            padding: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .form-group.col-2 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .content-wrapper {
            padding: 1rem;
        }
        
        .add-profile-form {
            padding: 1.25rem;
        }
        
        .page-title h3 {
            font-size: 1.5rem;
        }
    }

    /* Dark Mode Support (Optional) */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e4e6eb;
            --light-text: #b0b3b8;
            --border-color: #2a2a2a;
            --secondary-color: #e4e6eb;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        textarea {
            background-color: #242424;
        }
        
        input[type="file"] {
            background-color: rgba(52, 152, 219, 0.1);
        }
    }



    /* Add these styles for the gallery image deletion feature */
    .gallery-image-container {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .delete-image-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: var(--danger-color);
        color: white;
        border: 1px solid white;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        opacity: 0.8;
        z-index: 5;
    }

    .delete-image-btn:hover {
        opacity: 1;
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    /* Animation for image removal */
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }

    .fade-out {
        animation: fadeOut 0.3s ease forwards;
    }

    /* New image preview styling */
    
    /* Photo Cropping Styles */
    .photo-crop-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
    }
    
    .crop-modal-content {
        background-color: white;
        margin: 2% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    .crop-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .crop-modal-header h4 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .crop-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .crop-close:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }
    
    .crop-modal-body {
        padding: 1.5rem;
        flex: 1;
        overflow: auto;
    }
    
    .crop-container {
        width: 100%;
        max-height: 400px;
        margin-bottom: 1rem;
    }
    
    .crop-container img {
        max-width: 100%;
        height: auto;
        display: block;
    }
    
    .crop-controls {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }
    
    .aspect-ratio-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .aspect-btn {
        padding: 0.5rem 1rem;
        border: 2px solid var(--border-color);
        background: white;
        border-radius: 20px;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .aspect-btn.active,
    .aspect-btn:hover {
        border-color: var(--primary-color);
        background-color: var(--primary-color);
        color: white;
    }
    
    .crop-preview {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .preview-box {
        text-align: center;
    }
    
    .preview-box h6 {
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: var(--light-text);
        font-weight: 600;
    }
    
    .preview-circle,
    .preview-square {
        border: 2px solid var(--border-color);
        overflow: hidden;
        background-color: #f8f9fa;
        margin: 0 auto;
    }
    
    .preview-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
    }
    
    .preview-square {
        width: 100px;
        height: 80px;
        border-radius: 8px;
    }
    
    .crop-modal-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        background-color: #f8f9fa;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .crop-buttons {
        display: flex;
        gap: 1rem;
    }
    
    .btn-crop {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-crop-cancel {
        background-color: #6c757d;
        color: white;
    }
    
    .btn-crop-cancel:hover {
        background-color: #5a6268;
    }
    
    .btn-crop-save {
        background: linear-gradient(135deg, var(--success-color), #27ae60);
        color: white;
    }
    
    .btn-crop-save:hover {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }
    
    .crop-info {
        font-size: 0.875rem;
        color: var(--light-text);
        margin-bottom: 1rem;
        padding: 1rem;
        background-color: #e8f4f8;
        border-radius: 6px;
        border-left: 4px solid var(--primary-color);
    }
    
    .crop-info i {
        color: var(--primary-color);
        margin-right: 0.5rem;
    }
    
    /* Enhanced Photo Preview */
    .photo-preview-container {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        margin-top: 1rem;
    }
    
    .current-photo {
        position: relative;
        display: inline-block;
    }
    
    .photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid var(--border-color);
        transition: var(--transition);
    }
    
    .photo-preview:hover {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }
    
    .change-photo-btn {
        position: absolute;
        bottom: -10px;
        right: -10px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        border: 3px solid white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
    }
    
    .change-photo-btn:hover {
        background: var(--primary-hover);
        transform: scale(1.1);
    }
    
    /* Responsive Design for Crop Modal */
    @media (max-width: 768px) {
        .crop-modal-content {
            width: 95%;
            margin: 5% auto;
        }
        
        .crop-controls {
            flex-direction: column;
            align-items: stretch;
        }
        
        .aspect-ratio-buttons {
            justify-content: center;
        }
        
        .crop-preview {
            justify-content: center;
        }
        
        .crop-modal-footer {
            flex-direction: column;
        }
        
        .crop-buttons {
            justify-content: center;
        }
    }
    .new-image-preview {
        position: relative;
        display: inline-block;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    /* Modern layout overrides */
    .profile-edit-page {
        width: 100%;
        padding: 2.8rem 1.6rem 3.6rem;
        background: var(--page-bg);
    }

    .profile-edit-shell {
        max-width: 1180px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 2.4rem;
    }

    .profile-hero {
        position: relative;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.8rem;
        padding: 2.6rem 2.8rem;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.16), rgba(14, 165, 233, 0.18));
        overflow: hidden;
        box-shadow: 0 28px 56px rgba(15, 23, 42, 0.12);
    }

    .profile-hero::before,
    .profile-hero::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        opacity: 0.65;
    }

    .profile-hero::before {
        width: 340px;
        height: 340px;
        top: -160px;
        right: -150px;
        background: rgba(79, 70, 229, 0.38);
    }

    .profile-hero::after {
        width: 260px;
        height: 260px;
        bottom: -160px;
        left: -130px;
        background: rgba(14, 165, 233, 0.22);
    }

    .profile-hero > * {
        position: relative;
        z-index: 1;
    }

    .profile-hero__meta {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
        color: var(--text-dark);
    }

    .profile-hero__eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.45rem 1.3rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.72);
        border: 1px solid rgba(255, 255, 255, 0.82);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.14em;
    }

    .profile-hero__meta h1 {
        margin: 0;
        font-size: 2.35rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .profile-hero__meta p {
        margin: 0;
        line-height: 1.7;
        max-width: 520px;
        color: rgba(15, 23, 42, 0.8);
    }

    .profile-hero__breadcrumb {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 0.85rem;
        font-size: 0.85rem;
        color: rgba(15, 23, 42, 0.72);
    }

    .profile-hero__breadcrumb li {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .profile-hero__breadcrumb li:not(:last-child)::after {
        content: '•';
        font-size: 0.65rem;
        opacity: 0.6;
    }

    .profile-hero__breadcrumb a {
        color: inherit;
        text-decoration: none;
        transition: color 0.18s ease;
    }

    .profile-hero__breadcrumb a:hover {
        color: var(--primary);
    }

    .profile-hero__actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.9rem;
        justify-content: flex-end;
        align-items: flex-start;
    }

    .btn-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.95rem 1.95rem;
        border-radius: 999px;
        font-weight: 600;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease, color 0.18s ease;
    }

    .btn-pill i {
        font-size: 0.95rem;
    }

    .btn-pill--primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        box-shadow: 0 22px 40px rgba(79, 70, 229, 0.28);
    }

    .btn-pill--primary:hover {
        transform: translateY(-2px);
    }

    .btn-pill--outline {
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
        border: 1px solid rgba(79, 70, 229, 0.28);
    }

    .btn-pill--outline:hover {
        background: rgba(79, 70, 229, 0.18);
        transform: translateY(-1px);
    }

    .form-card {
        background: var(--surface);
        border-radius: 28px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 32px 64px rgba(15, 23, 42, 0.12);
        overflow: hidden;
    }

    .form-card__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.6rem;
        padding: 2.1rem 2.6rem 1.8rem;
        border-bottom: 1px solid rgba(148, 163, 184, 0.18);
    }

    .form-card__head h2 {
        margin: 0;
        font-size: 1.36rem;
        font-weight: 700;
        color: var(--text-dark);
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
    }

    .form-card__head h2 i {
        color: var(--primary);
    }

    .form-card__head p {
        margin: 0.35rem 0 0;
        color: var(--muted);
        max-width: 520px;
        line-height: 1.6;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.6rem 1.2rem;
        border-radius: 999px;
        background: rgba(79, 70, 229, 0.12);
        color: var(--primary-dark);
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .form-card__body {
        padding: 2.2rem 2.6rem 2.6rem;
        display: flex;
        flex-direction: column;
        gap: 2.4rem;
    }

    .form-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.96), rgba(244, 247, 255, 0.96));
        border-radius: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 22px 42px rgba(15, 23, 42, 0.08);
        padding: 1.9rem 2.1rem 2.2rem;
        margin: 0;
    }

    .form-section + .form-section {
        margin-top: 1.6rem;
    }

    .form-section-title {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.4rem;
        position: relative;
    }

    .form-section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.6rem;
        width: 42px;
        height: 3px;
        border-radius: 999px;
        /* background: linear-gradient(135deg, rgba(79, 70, 229, 0.4), rgba(14, 165, 233, 0.4)); */
    }

    .form-group {
        margin-bottom: 1.1rem;
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group.col-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.4rem;
    }

    .form-group.col-full {
        width: 100%;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 0.9rem 1.05rem;
        border: 1px solid rgba(148, 163, 184, 0.45);
        border-radius: 16px;
        background: var(--surface);
        font-size: 0.95rem;
        color: var(--text-dark);
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.16);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        padding: 0.95rem 1.8rem;
        border-radius: 999px;
        font-size: 0.95rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        box-shadow: 0 18px 32px rgba(79, 70, 229, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 22px 40px rgba(79, 70, 229, 0.28);
    }

    .photo-preview {
        width: 140px;
        height: 140px;
        border-radius: 18px;
        border: 4px solid rgba(148, 163, 184, 0.2);
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.12);
    }

    .change-photo-btn {
        bottom: -14px;
        right: -14px;
        width: 42px;
        height: 42px;
        border: 4px solid var(--surface);
        box-shadow: 0 14px 24px rgba(79, 70, 229, 0.28);
    }

    .image-preview {
        gap: 0.9rem;
    }

    .gallery-image-container,
    .new-image-preview {
        width: 92px;
        height: 92px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.1);
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .profile-edit-page {
            padding: 2.2rem 1.4rem 2.8rem;
        }

        .profile-hero {
            padding: 2.2rem 2.1rem;
        }

        .form-card__body {
            padding: 2rem 1.9rem 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .profile-edit-page {
            padding: 1.8rem 1.1rem 2.4rem;
        }

        .profile-hero {
            grid-template-columns: 1fr;
            padding: 2rem 1.7rem;
            gap: 1.4rem;
        }

        .profile-hero__actions {
            width: 100%;
            justify-content: flex-start;
        }

        .btn-pill {
            width: 100%;
            justify-content: center;
        }

        .form-card__body {
            padding: 1.6rem 1.4rem 1.8rem;
            gap: 1.8rem;
        }

        .form-group.col-2 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .photo-preview-container {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 540px) {
        .profile-hero__meta h1 {
            font-size: 1.85rem;
        }

        .profile-hero__meta p {
            font-size: 0.95rem;
        }

        .profile-hero__breadcrumb {
            flex-direction: column;
            gap: 0.35rem;
        }

        .form-card__head {
            flex-direction: column;
            padding: 1.65rem 1.6rem 1.4rem;
        }

        .status-pill {
            align-self: flex-start;
        }

        .form-section {
            padding: 1.35rem 1.2rem 1.6rem;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }

        .gallery-image-container,
        .new-image-preview {
            width: 78px;
            height: 78px;
        }
    }

</style>
@endsection
@section('content')
<div class="profile-edit-page">
    <div class="profile-edit-shell">
        <section class="profile-hero">
            <div class="profile-hero__meta">
                <span class="profile-hero__eyebrow"><i class="fas fa-user-cog"></i>Profile Management</span>
                <h1>Edit Your Professional Profile</h1>
                <p>Keep your personal, professional, and banking information up to date so clients always see your best self.</p>
                <ul class="profile-hero__breadcrumb">
                    <li><a href="{{ route('professional.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('professional.profile.index') }}">Profile</a></li>
                    <li class="active" aria-current="page">Edit Profile</li>
                </ul>
            </div>
            <div class="profile-hero__actions">
                <a href="{{ route('professional.profile.index') }}" class="btn-pill btn-pill--outline">
                    <i class="fas fa-arrow-left"></i>
                    Back to Overview
                </a>
                <a href="{{ route('professional.events.create') }}" class="btn-pill btn-pill--primary">
                    <i class="fas fa-calendar-plus"></i>
                    Create Event
                </a>
            </div>
        </section>

        <section class="form-card add-profile-form fade-in">
            <header class="form-card__head">
                <div>
                    <h2><i class="fas fa-file-signature"></i>Complete Your Profile</h2>
                    <p>All the details you provide help us match you with the right clients and opportunities.</p>
                </div>
                <span class="status-pill">
                    <i class="fas fa-clock"></i>
                    Updated {{ $profile->updated_at ? $profile->updated_at->diffForHumans() : 'just now' }}
                </span>
            </header>
            <div class="form-card__body">
                <form id="profileForm">
                    @csrf
                    <div class="form-section">
                        <h4 class="form-section-title">Profile Information</h4>
                        <div class="form-group col-full">
                            <label for="photo">Profile Photo</label>
                            <div class="crop-info">
                                <i class="fas fa-info-circle"></i>
                                Upload a high-quality photo that will be perfectly cropped for all your profile displays. Click the edit button after upload to crop your image.
                            </div>
                            <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                            <input type="hidden" id="cropped_photo" name="cropped_photo">
                            
                            <div class="photo-preview-container">
                                @if($profile->photo)
                                    <div class="current-photo">
                                        <img src="{{ file_exists(public_path('storage/'.$profile->photo)) ? asset('storage/'.$profile->photo) : asset('img/default-avatar.jpg') }}" alt="Current Photo" class="photo-preview" id="photoPreview">
                                        <button type="button" class="change-photo-btn" id="changePhotoBtn" title="Change Photo">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="current-photo">
                                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Photo" class="photo-preview" id="photoPreview">
                                        <button type="button" class="change-photo-btn" id="changePhotoBtn" title="Add Photo">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                                <div class="photo-instructions">
                                    <h6>Photo Requirements:</h6>
                                    <ul style="font-size: 0.875rem; color: var(--light-text); margin: 0; padding-left: 1rem;">
                                        <li>High resolution (minimum 400x400px)</li>
                                        <li>Clear, professional headshot</li>
                                        <li>Good lighting and focus</li>
                                        <li>JPG, PNG formats supported</li>
                                        <li>Maximum file size: 5MB</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-full">
                            <label for="gallery">Gallery Images (Multiple)</label>
                            <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
                            <div class="file-input-wrapper">
                                @if($profile->gallery)
                                    <div class="image-preview">
                                        @php
                                            $gallery = is_array($profile->gallery) ? $profile->gallery : json_decode($profile->gallery, true);
                                            $gallery = is_array($gallery) ? $gallery : [];
                                        @endphp
                                        @if(!empty($gallery))
                                            @foreach($gallery as $index => $img)
                                                <div class="gallery-image-container" id="gallery-image-{{ $index }}">
                                                    <button type="button" class="delete-image-btn" data-path="{{ $img }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <img src="{{ asset('storage/'.$img) }}" alt="Gallery Image" width="80">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="deleted_images" id="deleted_images" value="">
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="Name">Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $profile->professional->name ?? 'N/A' ) }}" required>
                                <div class="form-control-feedback"></div>
                            </div>
                            <div>
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $profile->email) }}" required>
                                <div class="form-control-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}">
                            </div>
                            <div>
                                <label for="specialization">Specialization</label>
                                <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $profile->specialization) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-title">Professional Details</h4>
                        <div class="form-group col-2">
                            <div>
                                <label for="experience">Years of Experience</label>
                                <input type="text" id="experience" name="experience" value="{{ old('experience', $profile->experience) }}">
                            </div>
                            <div>
                                <label for="startingPrice">Starting Price (e.g., 5000 or 5000-8000)</label>
                                <input type="text" id="startingPrice" name="startingPrice" value="{{ old('startingPrice', $profile->starting_price) }}" placeholder="Price per session (e.g., 1000, 1000-2000, 1500)">
                            </div>
                        </div>
                        <div class="form-group col-full">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3">{{ old('address', $profile->address) }}</textarea>
                        </div>
                        <div class="form-group col-full">
                            <label for="education">Education Details</label>
                            <textarea id="education" name="education" rows="3">{{ old('education', $profile->education) }}</textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-title">GST Information (Optional)</h4>
                        <div class="form-group col-2">
                            <div>
                                <label for="gst_number">GST Number</label>
                                <input type="text" id="gst_number" name="gst_number" value="{{ old('gst_number', $profile->gst_number) }}">
                                <small class="text-muted">Optional: Enter your GST number if applicable</small>
                            </div>
                            <div class="gst-certificate-group" style="{{ $profile->gst_number ? 'display: block;' : 'display: none;' }}">
                                <label for="gst_certificate">GST Certificate</label>
                                <input type="file" id="gst_certificate" name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="file-input-wrapper">
                                    @if($profile->gst_certificate)
                                        <a href="{{ asset('storage/'.$profile->gst_certificate) }}" target="_blank">View GST Certificate</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-full">
                            <label for="gst_address">GST Address</label>
                            <textarea id="gst_address" name="gst_address" rows="3" placeholder="GST Address (Optional)">{{ old('gst_address', $profile->gst_address) }}</textarea>
                            <small class="text-muted">Optional: Enter your GST registered address</small>
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="state_code">State Code</label>
                                <select id="state_code" name="state_code">
                                    <option value="">Select State (Optional)</option>
                                    @php
                                        $selectedStateCode = old('state_code', $profile->state_code ?? '');
                                    @endphp
                                    <option value="01" data-state="Jammu and Kashmir" {{ $selectedStateCode == '01' ? 'selected' : '' }}>01 - Jammu and Kashmir</option>
                                    <option value="02" data-state="Himachal Pradesh" {{ $selectedStateCode == '02' ? 'selected' : '' }}>02 - Himachal Pradesh</option>
                                    <option value="03" data-state="Punjab" {{ $selectedStateCode == '03' ? 'selected' : '' }}>03 - Punjab</option>
                                    <option value="04" data-state="Chandigarh" {{ $selectedStateCode == '04' ? 'selected' : '' }}>04 - Chandigarh</option>
                                    <option value="05" data-state="Uttarakhand" {{ $selectedStateCode == '05' ? 'selected' : '' }}>05 - Uttarakhand</option>
                                    <option value="06" data-state="Haryana" {{ $selectedStateCode == '06' ? 'selected' : '' }}>06 - Haryana</option>
                                    <option value="07" data-state="Delhi" {{ $selectedStateCode == '07' ? 'selected' : '' }}>07 - Delhi</option>
                                    <option value="08" data-state="Rajasthan" {{ $selectedStateCode == '08' ? 'selected' : '' }}>08 - Rajasthan</option>
                                    <option value="09" data-state="Uttar Pradesh" {{ $selectedStateCode == '09' ? 'selected' : '' }}>09 - Uttar Pradesh</option>
                                    <option value="10" data-state="Bihar" {{ $selectedStateCode == '10' ? 'selected' : '' }}>10 - Bihar</option>
                                    <option value="11" data-state="Sikkim" {{ $selectedStateCode == '11' ? 'selected' : '' }}>11 - Sikkim</option>
                                    <option value="12" data-state="Arunachal Pradesh" {{ $selectedStateCode == '12' ? 'selected' : '' }}>12 - Arunachal Pradesh</option>
                                    <option value="13" data-state="Nagaland" {{ $selectedStateCode == '13' ? 'selected' : '' }}>13 - Nagaland</option>
                                    <option value="14" data-state="Manipur" {{ $selectedStateCode == '14' ? 'selected' : '' }}>14 - Manipur</option>
                                    <option value="15" data-state="Mizoram" {{ $selectedStateCode == '15' ? 'selected' : '' }}>15 - Mizoram</option>
                                    <option value="16" data-state="Tripura" {{ $selectedStateCode == '16' ? 'selected' : '' }}>16 - Tripura</option>
                                    <option value="17" data-state="Meghalaya" {{ $selectedStateCode == '17' ? 'selected' : '' }}>17 - Meghalaya</option>
                                    <option value="18" data-state="Assam" {{ $selectedStateCode == '18' ? 'selected' : '' }}>18 - Assam</option>
                                    <option value="19" data-state="West Bengal" {{ $selectedStateCode == '19' ? 'selected' : '' }}>19 - West Bengal</option>
                                    <option value="20" data-state="Jharkhand" {{ $selectedStateCode == '20' ? 'selected' : '' }}>20 - Jharkhand</option>
                                    <option value="21" data-state="Odisha" {{ $selectedStateCode == '21' ? 'selected' : '' }}>21 - Odisha</option>
                                    <option value="22" data-state="Chhattisgarh" {{ $selectedStateCode == '22' ? 'selected' : '' }}>22 - Chhattisgarh</option>
                                    <option value="23" data-state="Madhya Pradesh" {{ $selectedStateCode == '23' ? 'selected' : '' }}>23 - Madhya Pradesh</option>
                                    <option value="24" data-state="Gujarat" {{ $selectedStateCode == '24' ? 'selected' : '' }}>24 - Gujarat</option>
                                    <option value="25" data-state="Daman and Diu" {{ $selectedStateCode == '25' ? 'selected' : '' }}>25 - Daman and Diu</option>
                                    <option value="26" data-state="Dadra and Nagar Haveli" {{ $selectedStateCode == '26' ? 'selected' : '' }}>26 - Dadra and Nagar Haveli</option>
                                    <option value="27" data-state="Maharashtra" {{ $selectedStateCode == '27' ? 'selected' : '' }}>27 - Maharashtra</option>
                                    <option value="28" data-state="Andhra Pradesh" {{ $selectedStateCode == '28' ? 'selected' : '' }}>28 - Andhra Pradesh</option>
                                    <option value="29" data-state="Karnataka" {{ $selectedStateCode == '29' ? 'selected' : '' }}>29 - Karnataka</option>
                                    <option value="30" data-state="Goa" {{ $selectedStateCode == '30' ? 'selected' : '' }}>30 - Goa</option>
                                    <option value="31" data-state="Lakshadweep" {{ $selectedStateCode == '31' ? 'selected' : '' }}>31 - Lakshadweep</option>
                                    <option value="32" data-state="Kerala" {{ $selectedStateCode == '32' ? 'selected' : '' }}>32 - Kerala</option>
                                    <option value="33" data-state="Tamil Nadu" {{ $selectedStateCode == '33' ? 'selected' : '' }}>33 - Tamil Nadu</option>
                                    <option value="34" data-state="Puducherry" {{ $selectedStateCode == '34' ? 'selected' : '' }}>34 - Puducherry</option>
                                    <option value="35" data-state="Andaman and Nicobar Islands" {{ $selectedStateCode == '35' ? 'selected' : '' }}>35 - Andaman and Nicobar Islands</option>
                                    <option value="36" data-state="Telangana" {{ $selectedStateCode == '36' ? 'selected' : '' }}>36 - Telangana</option>
                                    <option value="37" data-state="Andhra Pradesh (New)" {{ $selectedStateCode == '37' ? 'selected' : '' }}>37 - Andhra Pradesh (New)</option>
                                    <option value="38" data-state="Ladakh" {{ $selectedStateCode == '38' ? 'selected' : '' }}>38 - Ladakh</option>
                                </select>
                                <small class="text-muted">Select your state for GST registration (if applicable)</small>
                            </div>
                            <div>
                                <label for="state_name">State Name</label>
                                <input type="text" id="state_name" name="state_name" value="{{ old('state_name', $profile->state_name) }}" readonly placeholder="Auto-filled based on state code">
                                <small class="text-muted">This field is auto-filled when you select a state code</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-title">Bank Account Details</h4>
                        <div class="form-group col-2">
                            <div>
                                <label for="account_holder_name">Account Holder Name</label>
                                <input type="text" id="account_holder_name" name="account_holder_name" value="{{ old('account_holder_name', $profile->account_holder_name) }}" placeholder="Full name as per bank records">
                                <small class="text-muted">Enter name exactly as it appears in your bank account</small>
                            </div>
                            <div>
                                <label for="bank_name">Bank Name</label>
                                <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', $profile->bank_name) }}" placeholder="e.g., State Bank of India">
                                <small class="text-muted">Full name of your bank</small>
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="account_number">Account Number</label>
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number', $profile->account_number) }}" placeholder="Bank account number">
                                <small class="text-muted">Your bank account number</small>
                            </div>
                            <div>
                                <label for="ifsc_code">IFSC Code</label>
                                <input type="text" id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code', $profile->ifsc_code) }}" placeholder="e.g., SBIN0000123" style="text-transform: uppercase;">
                                <small class="text-muted">11-character IFSC code of your bank branch</small>
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="account_type">Account Type</label>
                                <select id="account_type" name="account_type">
                                    <option value="">Select Account Type</option>
                                    <option value="savings" {{ old('account_type', $profile->account_type) == 'savings' ? 'selected' : '' }}>Savings Account</option>
                                    <option value="current" {{ old('account_type', $profile->account_type) == 'current' ? 'selected' : '' }}>Current Account</option>
                                </select>
                                <small class="text-muted">Type of your bank account</small>
                            </div>
                            <div>
                                <label for="bank_branch">Branch Name</label>
                                <input type="text" id="bank_branch" name="bank_branch" value="{{ old('bank_branch', $profile->bank_branch) }}" placeholder="Branch name/location">
                                <small class="text-muted">Name or location of your bank branch (optional)</small>
                            </div>
                        </div>
                        <div class="form-group col-full">
                            <label for="bank_document">Bank Account Proof (Cancelled Cheque/Passbook)</label>
                            <input type="file" id="bank_document" name="bank_document" accept=".pdf,.jpg,.jpeg,.png">
                            <div class="file-input-wrapper">
                                @if($profile->bank_document)
                                    <a href="{{ asset('storage/'.$profile->bank_document) }}" target="_blank">View Bank Document</a>
                                @endif
                            </div>
                            <small class="text-muted">Upload cancelled cheque or passbook first page for verification</small>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-title">Documents</h4>
                        <div class="form-group col-full">
                            <label for="qualificationDocument">Qualification Document</label>
                            <input type="file" id="qualificationDocument" name="qualificationDocument" accept=".pdf,.doc,.docx,image/*">
                            <div class="file-input-wrapper">
                                @if($profile->qualification_document)
                                    <a href="{{ asset('storage/'.$profile->qualification_document) }}" target="_blank">View Document</a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <div>
                                <label for="idProofDocument">ID Proof Document (Aadhaar / PAN Card)</label>
                                <input type="file" id="idProofDocument" name="idProofDocument" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="file-input-wrapper">
                                    @if($profile->id_proof_document)
                                        <a href="{{ asset('storage/'.$profile->id_proof_document) }}" target="_blank">View ID Proof</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-title">Additional Information</h4>
                        <div class="form-group col-full">
                            <label for="comments">Additional Comments</label>
                            <textarea id="comments" name="comments" rows="3">{{ old('comments', $profile->comments) }}</textarea>
                        </div>
                        <div class="form-group col-full">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group col-full">
                        <button type="submit" id="submitBtn" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Save Profile
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<!-- Photo Crop Modal -->
<div id="photoCropModal" class="photo-crop-modal">
    <div class="crop-modal-content">
        <div class="crop-modal-header">
            <h4><i class="fas fa-crop-alt"></i> Crop Your Profile Photo</h4>
            <button type="button" class="crop-close" id="closeCropModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="crop-modal-body">
            <div class="crop-info">
                <i class="fas fa-info-circle"></i>
                Crop your photo to ensure it looks perfect across all platforms. Choose an aspect ratio and adjust the crop area.
            </div>
            
            <div class="crop-controls">
                <div>
                    <label style="margin-bottom: 0.5rem; font-weight: 600;">Aspect Ratio:</label>
                    <div class="aspect-ratio-buttons">
                        <button type="button" class="aspect-btn" data-ratio="1" title="Square (1:1) - Perfect for profile pictures">
                            <i class="fas fa-square"></i> Square
                        </button>
                        <button type="button" class="aspect-btn" data-ratio="4/3" title="Landscape (4:3) - Good for headers">
                            <i class="fas fa-rectangle-landscape"></i> 4:3
                        </button>
                        <button type="button" class="aspect-btn" data-ratio="16/9" title="Widescreen (16:9) - For banners">
                            <i class="fas fa-rectangle-wide"></i> 16:9
                        </button>
                        <button type="button" class="aspect-btn active" data-ratio="NaN" title="Free crop - Any size">
                            <i class="fas fa-crop"></i> Free
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="crop-container">
                <img id="cropImage" src="" alt="Image to crop">
            </div>
            
            <div class="crop-preview">
                <div class="preview-box">
                    <h6>Circle Preview</h6>
                    <div class="preview-circle" id="previewCircle"></div>
                </div>
                <div class="preview-box">
                    <h6>Square Preview</h6>
                    <div class="preview-square" id="previewSquare"></div>
                </div>
            </div>
        </div>
        <div class="crop-modal-footer">
            <div class="crop-info" style="margin: 0; padding: 0.5rem 1rem; background: none; border: none; font-size: 0.8rem;">
                <i class="fas fa-mouse"></i> Drag to move • <i class="fas fa-expand-arrows-alt"></i> Drag corners to resize
            </div>
            <div class="crop-buttons">
                <button type="button" class="btn-crop btn-crop-cancel" id="cancelCrop">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" class="btn-crop btn-crop-save" id="saveCrop">
                    <i class="fas fa-check"></i> Ok
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
// Photo Cropping Functionality
let cropper = null;
let currentFile = null;

// Array to store deleted image paths
const deletedImages = [];

// Photo Cropping Functions
function initializeCropper(imageFile) {
    const modal = document.getElementById('photoCropModal');
    const cropImage = document.getElementById('cropImage');
    
    // Create object URL for the selected image
    const imageUrl = URL.createObjectURL(imageFile);
    cropImage.src = imageUrl;
    
    // Show modal
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    // Initialize cropper after image loads
    cropImage.onload = function() {
        if (cropper) {
            cropper.destroy();
        }
        
        cropper = new Cropper(cropImage, {
            aspectRatio: NaN, // Free crop by default
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.8,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            responsive: true,
            modal: true,
            background: true,
            ready: function () {
                updatePreviews();
            },
            cropend: function () {
                updatePreviews();
            }
        });
    };
}

function updatePreviews() {
    if (!cropper) return;
    
    const canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200,
        imageSmoothingQuality: 'high'
    });
    
    const circleCanvas = cropper.getCroppedCanvas({
        width: 80,
        height: 80,
        imageSmoothingQuality: 'high'
    });
    
    const squareCanvas = cropper.getCroppedCanvas({
        width: 100,
        height: 80,
        imageSmoothingQuality: 'high'
    });
    
    if (canvas && circleCanvas && squareCanvas) {
        const previewCircle = document.getElementById('previewCircle');
        const previewSquare = document.getElementById('previewSquare');
        
        // Clear previous previews
        previewCircle.innerHTML = '';
        previewSquare.innerHTML = '';
        
        // Add new previews
        const circleImg = circleCanvas.toDataURL();
        const squareImg = squareCanvas.toDataURL();
        
        previewCircle.style.backgroundImage = `url(${circleImg})`;
        previewCircle.style.backgroundSize = 'cover';
        previewCircle.style.backgroundPosition = 'center';
        
        previewSquare.style.backgroundImage = `url(${squareImg})`;
        previewSquare.style.backgroundSize = 'cover';
        previewSquare.style.backgroundPosition = 'center';
    }
}

function closeCropModal() {
    const modal = document.getElementById('photoCropModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    
    // Reset file input
    const photoInput = document.getElementById('photo');
    photoInput.value = '';
    currentFile = null;
}

function saveCroppedImage() {
    if (!cropper) return;
    
    // Get cropped canvas with high quality
    const canvas = cropper.getCroppedCanvas({
        width: 800,
        height: 800,
        imageSmoothingQuality: 'high',
        fillColor: '#fff'
    });
    
    if (canvas) {
        // Convert to blob
        canvas.toBlob(function(blob) {
            // Create a new file from the blob
            const fileName = currentFile.name.replace(/\.[^/.]+$/, '') + '_cropped.jpg';
            const croppedFile = new File([blob], fileName, {
                type: 'image/jpeg',
                lastModified: Date.now()
            });
            
            // Update preview
            const photoPreview = document.getElementById('photoPreview');
            const previewUrl = URL.createObjectURL(blob);
            photoPreview.src = previewUrl;
            
            // Store the cropped image data
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cropped_photo').value = e.target.result;
            };
            reader.readAsDataURL(blob);
            
            // Close modal
            closeCropModal();
            
            // Show success message
            showToast('Photo cropped successfully!', 'success');
            
        }, 'image/jpeg', 0.9);
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Change photo button
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const photoInput = document.getElementById('photo');
    
    changePhotoBtn.addEventListener('click', function() {
        photoInput.click();
    });
    
    // Photo input change
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            // Validate file size (5MB max)
            if (file.size > 5 * 1024 * 1024) {
                showToast('File size must be less than 5MB', 'error');
                this.value = '';
                return;
            }
            
            currentFile = file;
            initializeCropper(file);
        } else if (file) {
            showToast('Please select a valid image file', 'error');
            this.value = '';
        }
    });
    
    // Aspect ratio buttons
    document.querySelectorAll('.aspect-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.aspect-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update cropper aspect ratio
            if (cropper) {
                const ratio = parseFloat(this.dataset.ratio);
                cropper.setAspectRatio(ratio);
                setTimeout(updatePreviews, 100);
            }
        });
    });
    
    // Close modal buttons
    document.getElementById('closeCropModal').addEventListener('click', closeCropModal);
    document.getElementById('cancelCrop').addEventListener('click', closeCropModal);
    
    // Save crop button
    document.getElementById('saveCrop').addEventListener('click', saveCroppedImage);
    
    // Close modal when clicking outside
    document.getElementById('photoCropModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeCropModal();
        }
    });
});

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#2ecc71' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Handle delete button click
$(document).on('click', '.delete-image-btn', function() {
    const imagePath = $(this).data('path');
    const container = $(this).closest('.gallery-image-container');
    
    // Add confirmation dialog
    if (confirm('Are you sure you want to delete this image?')) {
        // Add fade-out animation
        container.addClass('fade-out');
        
        // Add the image path to the deleted images array
        deletedImages.push(imagePath);
        
        // Update the hidden input with deleted images
        $('#deleted_images').val(JSON.stringify(deletedImages));
        
        // Remove the element after animation
        setTimeout(() => {
            container.remove();
        }, 300);
    }
});

// Handle form submission
$('#profileForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    formData.append('_method', 'PUT');
    
    // Add the deleted images to formData if any
    if (deletedImages.length > 0) {
        formData.set('deleted_images', JSON.stringify(deletedImages));
    }
    
    // Add loading state
    $('#submitBtn').addClass('btn-loading').html('');
    
    // Reset validation state
    $('.is-invalid').removeClass('is-invalid');
    $('.form-control-feedback').text('');

    $.ajax({
        url: "{{ route('professional.profile.update', ['profile' => $profile->id]) }}", 
        method: "POST", 
        data: formData,
        contentType: false, 
        processData: false, 
        cache: false, 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response);
            
            if (response.status === 'success') {
                toastr.success(response.message);
                
                // Show success animation
                $('.add-profile-form').addClass('fade-in');
                
                setTimeout(function() {
                    window.location.href = "{{ route('professional.profile.index') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
                $('#submitBtn').removeClass('btn-loading').html('<i class="fas fa-save"></i> Save Profile');
            }
        },
        error: function(xhr) {
            $('#submitBtn').removeClass('btn-loading').html('<i class="fas fa-save"></i> Save Profile');
            
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                    
                    // Add validation styling
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).next('.form-control-feedback').text(value[0]);
                });
            } else {
                toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
            }
        }
    });
});

// Update file input preview functionality for gallery images
$('#gallery').change(function(e) {
    const fileInput = $(this);
    let previewContainer = fileInput.next('.file-input-wrapper').find('.image-preview');
    
    if (!previewContainer.length) {
        fileInput.next('.file-input-wrapper').append('<div class="image-preview"></div>');
        previewContainer = fileInput.next('.file-input-wrapper').find('.image-preview');
    }
    
    if (this.files && this.files.length > 0) {
        // For each file, create a preview with delete button
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                const uniqueId = 'new-img-' + Date.now() + '-' + i;
                
                reader.onload = function(e) {
                    const newImage = `
                        <div class="new-image-preview" id="${uniqueId}">
                            <button type="button" class="delete-image-btn" data-id="${uniqueId}">
                                <i class="fas fa-times"></i>
                            </button>
                            <img src="${e.target.result}" alt="New image" width="80">
                        </div>
                    `;
                    previewContainer.append(newImage);
                };
                
                reader.readAsDataURL(file);
            }
        }
    }
});

// Handle delete button for newly uploaded images
$(document).on('click', '.new-image-preview .delete-image-btn', function() {
    const containerId = $(this).data('id');
    const $container = $('#' + containerId);
    
    $container.addClass('fade-out');
    setTimeout(() => {
        $container.remove();
    }, 300);
});

// Rest of your existing JS code...

// Add form field validation on blur
$('input, textarea').blur(function() {
    const input = $(this);
    
    if (input.attr('required') && !input.val().trim()) {
        input.addClass('is-invalid');
        input.next('.form-control-feedback').text('This field is required');
    } else {
        input.removeClass('is-invalid');
        
        // Special validation for starting price
        if (input.attr('name') === 'startingPrice' && input.val().trim()) {
            const startingPrice = input.val().trim();
            const pricePattern = /^(\d+(\.\d{1,2})?(-\d+(\.\d{1,2})?)?)$/;
            
            if (!pricePattern.test(startingPrice)) {
                input.addClass('is-invalid');
                input.next('.form-control-feedback').text('Please enter a valid price (e.g., 1000 or 1000-2000)');
                return;
            }
        }
        
        if (input.val().trim()) {
            input.addClass('is-valid');
        } else {
            input.removeClass('is-valid');
        }
    }
});

// Add smooth scroll to sections
$('.form-section-title').click(function() {
    $(this).next().slideToggle(300);
});

// Add entrance animations
$(document).ready(function() {
    $('.form-section').each(function(index) {
        $(this).css({
            'animation-delay': (index * 0.1) + 's',
            'animation': 'fadeIn 0.5s ease forwards'
        });
    });
    
    // GST Number and Certificate Handler
    $('#gst_number').on('input', function() {
        var gstNumber = $(this).val().trim();
        if (gstNumber) {
            $('.gst-certificate-group').slideDown();
            $('#gst_certificate').attr('required', false); // Optional unless GST number is provided
        } else {
            $('.gst-certificate-group').slideUp();
            $('#gst_certificate').attr('required', false);
        }
    });
});
</script>
@endsection