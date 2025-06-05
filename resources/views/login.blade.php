<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - eRegistry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include icons and Bootstrap styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated background elements */
        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape-3 {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .medical-cross {
            position: absolute;
            width: 40px;
            height: 40px;
            top: 15%;
            right: 20%;
            color: rgba(255, 255, 255, 0.2);
            font-size: 40px;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.2; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.1); }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .login-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideInUp 0.8s ease-out;
        }

        .info-panel {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            animation: slideInLeft 0.8s ease-out 0.2s both;
        }

        .logo-section {
            margin-bottom: 2rem;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .logo i {
            font-size: 2rem;
            color: white;
        }

        .app-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .app-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .features {
            list-style: none;
            text-align: left;
        }

        .features li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .features li i {
            margin-right: 0.75rem;
            color: #4ade80;
            font-size: 1.1rem;
        }

        .login-panel {
            padding: 3rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
            color: #1f2937;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }

        .input-icon .form-input {
            padding-left: 2.75rem;
        }

        .input-icon .form-input:focus + i {
            color: #667eea;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-input {
            margin-right: 0.5rem;
            transform: scale(1.1);
        }

        .checkbox-label {
            color: #6b7280;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .login-button {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: none;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.2rem;
        }

        .alert li {
            margin-bottom: 0.25rem;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                margin: 1rem;
            }

            .info-panel {
                padding: 2rem 1.5rem;
            }

            .login-panel {
                padding: 2rem 1.5rem;
            }

            .app-title {
                font-size: 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 1rem 0.5rem;
            }

            .login-wrapper {
                margin: 0.5rem;
            }

            .info-panel,
            .login-panel {
                padding: 1.5rem 1rem;
            }
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Security indicator */
        .security-info {
            margin-top: 1rem;
            padding: 0.75rem;
            background: rgba(34, 197, 94, 0.1);
            border-radius: 8px;
            border-left: 3px solid #22c55e;
            font-size: 0.8rem;
            color: #166534;
        }

        .security-info i {
            margin-right: 0.5rem;
            color: #22c55e;
        }
    </style>
</head>
<body>
<!-- Animated background -->
<div class="background-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <i class="fas fa-plus medical-cross"></i>
</div>

<div class="login-container">
    <div class="login-wrapper">
        <!-- Information Panel -->
        <div class="info-panel">
            <div class="logo-section">
                <div class="logo">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1 class="app-title">eRegistry</h1>
                <p class="app-subtitle">Advanced Patient Registry & Monitoring System</p>
            </div>

            <ul class="features">
                <li>
                    <i class="fas fa-user-md"></i>
                    Comprehensive Patient Management
                </li>
                <li>
                    <i class="fas fa-chart-line"></i>
                    Real-time Monitoring & Analytics
                </li>
                <li>
                    <i class="fas fa-shield-alt"></i>
                    HIPAA Compliant & Secure
                </li>
                <li>
                    <i class="fas fa-mobile-alt"></i>
                    Multi-device Access
                </li>
            </ul>
        </div>

        <!-- Login Panel -->
        <div class="login-panel">
            <div class="login-header">
                <h2 class="login-title">Welcome Back</h2>
                <p class="login-subtitle">Please sign in to your account to continue</p>
            </div>

            <!-- Error message block -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{route('login.submit')}}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-icon">
                        <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                placeholder="Enter your email address"
                                value="{{ old('email') }}"
                                required>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-icon">
                        <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input"
                                placeholder="Enter your password"
                                required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input
                            type="checkbox"
                            class="checkbox-input"
                            id="remember"
                            name="remember">
                    <label class="checkbox-label" for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="login-button" id="loginBtn">
                    <span class="btn-text">Sign In</span>
                </button>

                <div class="security-info">
                    <i class="fas fa-lock"></i>
                    Your connection is secure and encrypted
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script>
    // Enhanced form submission with loading state
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const btn = document.getElementById('loginBtn');
        const btnText = btn.querySelector('.btn-text');

        // Add loading state
        btn.disabled = true;
        btnText.innerHTML = '<span class="loading"></span>Signing in...';

        // Optional: Add a small delay for better UX
        setTimeout(() => {
            // Form will submit naturally
        }, 500);
    });

    // Input focus animations
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Add subtle animations on load
    window.addEventListener('load', function() {
        document.body.style.opacity = '1';
    });
</script>
</body>
</html>