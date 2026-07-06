<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — StockManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #0369a1 45%, #06b6d4 100%);
            background-size: 200% 200%;
            animation: gradientMove 8s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Formes flottantes en arrière-plan */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            animation: float 6s ease-in-out infinite;
        }
        .shape1 { width: 200px; height: 200px; top: 10%; left: 8%; animation-delay: 0s; }
        .shape2 { width: 140px; height: 140px; bottom: 15%; right: 10%; animation-delay: 1.5s; }
        .shape3 { width: 90px; height: 90px; top: 60%; left: 15%; animation-delay: 3s; }
        .shape4 { width: 110px; height: 110px; top: 15%; right: 18%; animation-delay: 2s; }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(10deg); }
        }

        /* Logo animé */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 24px;
            position: relative;
            z-index: 2;
        }
        .logo-box {
            width: 80px;
            height: 80px;
            margin: 0 auto 14px;
            background: linear-gradient(135deg, #ffffff 0%, #ede9fe 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            animation: bounce 2.5s ease-in-out infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }
        .logo-text {
            color: #fff;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: 0.5px;
            text-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .logo-sub {
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            font-weight: 400;
            margin-top: 2px;
        }

        /* Card de connexion */
        .login-card {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(10px);
            border-radius: 22px;
            padding: 40px 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 60px rgba(45,27,105,0.35);
            position: relative;
            z-index: 2;
            animation: slideUp 0.6s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label { font-weight: 600; color: #2d1b69; font-size: 13px; }
        .form-control {
            border: 2px solid #ede9fe;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .form-control:focus {
    border-color: #0369a1;
    box-shadow: 0 0 0 4px rgba(3,105,161,0.12);
        }

        .btn-login {
    background: linear-gradient(135deg, #0369a1 0%, #0f172a 100%);
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-weight: 700;
            color: #fff;
            font-size: 15px;
            width: 100%;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 20px rgba(124,58,237,0.35);
            transition: all 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(124,58,237,0.45);
            color: #fff;
        }

        .form-check-input:checked { background-color: #7c3aed; border-color: #7c3aed; }
        a.forgot-link { color: #7c3aed; font-size: 13px; font-weight: 500; text-decoration: none; }
        a.forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="shape shape1"></div>
<div class="shape shape2"></div>
<div class="shape shape3"></div>
<div class="shape shape4"></div>

<div style="position:relative; z-index:2; width:100%; max-width:400px; padding: 0 16px;">
    <div class="logo-wrapper">
        <div class="logo-box">📦</div>
        <div class="logo-text">StockManager</div>
        <div class="logo-sub">Gestion de stock intelligente</div>
    </div>

    <div class="login-card">
        @if($errors->any())
            <div class="alert alert-danger small mb-3" style="border-radius:10px">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="vous@exemple.com">
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Se souvenir de moi</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                @endif
            </div>
            <button type="submit" class="btn-login">Se connecter</button>
        </form>
    </div>
</div>

</body>
</html>