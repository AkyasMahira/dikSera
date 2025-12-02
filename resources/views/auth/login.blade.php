<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login - DIK SERA</title>
    <link rel="icon" href="{{ asset('icon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --primary: #14b8a6;   /* teal */
            --secondary: #6366f1; /* ungu */
            --bg-base: #eef2ff;
            --glass: rgba(255,255,255,.96);
            --text-main: #0f172a;
            --text-muted: #6b7280;
            --radius: 18px;
            --shadow: 0 18px 45px rgba(15,23,42,.12);
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            color:var(--text-main);
            background:
              radial-gradient(circle at 0% 0%, rgba(20,184,166,.25), transparent 55%),
              radial-gradient(circle at 100% 0%, rgba(99,102,241,.25), transparent 55%),
              var(--bg-base);
            background-size: 140% 140%;
            animation: bgFloat 18s ease-in-out infinite;
        }

        @keyframes bgFloat{
            0%{ background-position: 0% 0%, 100% 0%, 50% 50%; }
            50%{ background-position: 20% 10%, 80% 5%, 50% 50%; }
            100%{ background-position: 0% 0%, 100% 0%, 50% 50%; }
        }

        .card-auth{
            width:100%;
            max-width:420px;
            background:var(--glass);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            border:1px solid rgba(209,213,219,.9);
            padding:2.2rem 2rem;
            position:relative;
            overflow:hidden;
            animation: fadeZoomIn .5s ease-out;
        }

        .card-auth::before{
            content:"";
            position:absolute;
            inset:-40%;
            background: radial-gradient(circle at 0% 0%, rgba(20,184,166,.14), transparent 55%);
            opacity:0;
            transform:translate3d(-10px,-10px,0);
            transition:opacity .5s ease, transform .5s ease;
            pointer-events:none;
        }

        .card-auth:hover::before{
            opacity:1;
            transform:translate3d(0,0,0);
        }

        @keyframes fadeZoomIn{
            from{ opacity:0; transform:translate3d(0,10px,0) scale(.97); }
            to{ opacity:1; transform:translate3d(0,0,0) scale(1); }
        }

        .section-label{
            font-size:.75rem;
            letter-spacing:.18em;
            text-transform:uppercase;
            color:var(--text-muted);
        }

        .form-label{
            font-size:.8rem;
            color:#4b5563;
        }

        .form-control{
            border-radius:12px;
            border:1px solid #e5e7eb;
            font-size:.9rem;
        }
        .form-control:focus{
            border-color:#14b8a6;
            box-shadow:0 0 0 1px rgba(20,184,166,.35);
        }

        .btn-primary-soft{
            background: linear-gradient(135deg, #22c1c3, #14b8a6);
            border:none;
            color:#ffffff;
            font-weight:600;
            box-shadow:0 10px 30px rgba(34,193,195,.25);
        }
        .btn-primary-soft:hover{
            filter:brightness(1.03);
            box-shadow:0 14px 38px rgba(34,193,195,.35);
        }

        .logo-box{
            height:60px;
            width:60px;
            border-radius:14px;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 0 0 3px rgba(148,163,184,.4);
        }
        .logo-box img{
            max-width:100%;
            max-height:100%;
            object-fit:cover;
        }

        .brand-text{
            letter-spacing:.05em;
            font-size:.9rem;
        }

        .alert{
            font-size:.8rem;
        }

        .input-group-text{
            background:#f9fafb;
            border-radius:12px;
            border:1px solid #e5e7eb;
        }

        .btn-eye{
            border-radius:0 12px 12px 0;
        }
    </style>
</head>
<body>

<div class="card-auth">
    {{-- Flash message --}}
    @if(session('ok'))
        <div class="alert alert-success py-2">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-center mb-4">
        <div class="d-flex flex-column align-items-center gap-2">
            <div class="logo-box">
                <img src="{{ asset('icon.png') }}" alt="icon">
            </div>
            <div class="brand-text text-muted">DIK SERA</div>
        </div>
        <div class="mt-3">
            <div class="section-label">Masuk ke sistem</div>
            <h5 class="mb-1">Login DIK SERA</h5>
            <p class="text-muted small mb-0">
                Digitalisasi Kompetensi, Sertifikasi & Evaluasi Perawat
            </p>
        </div>
    </div>

    <form action="{{ route('auth.login.process') }}" method="post">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control" required placeholder="perawat@rsudslg.go.id">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" name="password" id="passwordInput"
                       class="form-control" required placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary btn-eye"
                        onclick="togglePassword('passwordInput','passwordIcon')">
                    <i class="bi bi-eye" id="passwordIcon"></i>
                </button>
            </div>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label for="remember" class="form-check-label text-muted small">Ingat saya</label>
        </div>

        <button class="btn btn-primary-soft w-100 mb-3">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
    </form>

    <div class="text-center mt-1">
        <small class="text-muted">
            Belum punya akun?
            <a href="{{ route('auth.register.perawat') }}">Daftar sebagai Perawat</a>
        </small>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, iconId){
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if(!input) return;
    if(input.type === 'password'){
        input.type = 'text';
        if(icon) icon.classList.replace('bi-eye','bi-eye-slash');
    }else{
        input.type = 'password';
        if(icon) icon.classList.replace('bi-eye-slash','bi-eye');
    }
}
</script>
</body>
</html>
