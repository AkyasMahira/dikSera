<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title','DIK SERA')</title>
    <link rel="icon" href="{{ asset('icon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --primary: #14b8a6;
            --secondary: #6366f1;
            --bg-base: #eef2ff;
            --glass: rgba(255,255,255,.96);
            --text-main: #0f172a;
            --text-muted: #6b7280;
            --radius: 18px;
            --shadow: 0 18px 45px rgba(15,23,42,.08);
            --sidebar-width: 240px;
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            color:var(--text-main);
            background:
              radial-gradient(circle at 0% 0%, rgba(20,184,166,.25), transparent 55%),
              radial-gradient(circle at 100% 0%, rgba(99,102,241,.25), transparent 55%),
              var(--bg-base);
            background-size:140% 140%;
            animation:bgFloat 18s ease-in-out infinite;
        }

        @keyframes bgFloat{
            0%{background-position:0% 0%,100% 0%,50% 50%;}
            50%{background-position:20% 10%,80% 5%,50% 50%;}
            100%{background-position:0% 0%,100% 0%,50% 50%;}
        }

        .app-nav{
            background:linear-gradient(120deg,rgba(255,255,255,.98),rgba(255,255,255,.94));
            backdrop-filter:blur(16px);
            box-shadow:0 12px 35px rgba(15,23,42,.06);
            border-bottom:1px solid rgba(209,213,219,.7);
            position:sticky;
            top:0;
            z-index:100;
        }

        .page-shell{
            width:100%;
            max-width:100%;
            padding:0 1rem;
            margin:0;
        }

        .brand-logo{
            height:34px;width:34px;
            border-radius:10px;
            object-fit:cover;
            margin-right:8px;
            box-shadow:0 0 0 2px rgba(148,163,184,.4);
        }
        .brand-text{letter-spacing:.04em;font-size:.9rem;}

        .chip-role{
            padding:3px 9px;
            border-radius:999px;
            font-size:.75rem;
            text-transform:uppercase;
            letter-spacing:.07em;
            border:1px solid rgba(148,163,184,.8);
            color:var(--text-muted);
            background:#f9fafb;
        }

        .layout-shell{
            width:100%;
            max-width:100%;
            margin:1.5rem 0 2.5rem;
            padding:0 1rem;
        }

        .layout-main{
            display:flex;
            gap:1.25rem;
            align-items:flex-start;
        }

        .sidebar{
            width:var(--sidebar-width);
            flex:0 0 var(--sidebar-width);
            background:var(--glass);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            border:1px solid rgba(209,213,219,.9);
            padding:1rem .75rem;
            position:relative;
            transition:all .25s ease;
        }
        .sidebar.collapsed{
            width:0;
            flex:0 0 0;
            padding:0;
            border:none;
            box-shadow:none;
            opacity:0;
            pointer-events:none;
        }

        .sidebar-title{
            font-size:.8rem;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:.12em;
            color:var(--text-muted);
            padding:0 .25rem .4rem;
            border-bottom:1px solid rgba(226,232,240,.9);
            margin-bottom:.35rem;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            gap:.5rem;
            padding:.45rem .55rem;
            border-radius:12px;
            text-decoration:none;
            color:var(--text-main);
            font-size:.86rem;
            margin-bottom:.1rem;
            transition:background .18s ease,transform .12s ease;
        }
        .sidebar-menu a i{
            font-size:.95rem;
            color:#64748b;
        }
        .sidebar-menu a span{white-space:nowrap;}
        .sidebar-menu a.active{
            background:linear-gradient(120deg,rgba(20,184,166,.12),rgba(99,102,241,.12));
            color:#0f172a;
        }
        .sidebar-menu a:hover{
            background:rgba(226,232,240,.9);
            transform:translateY(-1px);
        }

        .content-wrapper{
            flex:1 1 auto;
            min-width:0;
            transition:width .25s ease;
        }

        .card-glass{
            background:var(--glass);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            border:1px solid rgba(209,213,219,.9);
            position:relative;
            overflow:hidden;
        }
        .card-glass-inner{
            position:relative;
            z-index:1;
            padding:1.25rem 1.3rem;
        }
        .card-glass::before{
            content:"";
            position:absolute;
            inset:-40%;
            background:radial-gradient(circle at 0% 0%,rgba(20,184,166,.14),transparent 55%);
            opacity:0;
            transform:translate3d(-10px,-10px,0);
            transition:opacity .5s ease,transform .5s ease;
            pointer-events:none;
        }
        .card-glass:hover::before{
            opacity:1;
            transform:translate3d(0,0,0);
        }

        .section-title{
            font-size:1.05rem;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:.5rem;
            margin-bottom:.9rem;
        }
        .section-title::before{
            content:"";
            display:inline-block;
            width:16px;height:16px;
            border-radius:999px;
            background:conic-gradient(from 180deg,#22c1c3,#6366f1,#22c1c3);
        }

        .btn-toggle-sidebar{
            border-radius:999px;
            border:none;
            background:rgba(15,23,42,.06);
            width:32px;height:32px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
        }

        @media (max-width:991px){
            .layout-main{flex-direction:column;}
            .sidebar{width:100%;flex:0 0 auto;}
            .sidebar.collapsed{max-height:0;}
        }
    </style>

    @stack('head')
</head>
<body>
<nav class="navbar navbar-expand-lg app-nav">
    <div class="container-fluid page-shell">
        <div class="d-flex align-items-center gap-2">
            <button id="btnToggleSidebar" class="btn-toggle-sidebar me-1" type="button">
                <i class="bi bi-layout-sidebar"></i>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('icon.png') }}" alt="icon" class="brand-logo">
                <span class="fw-semibold brand-text">DIK SERA</span>
            </a>
        </div>

        <div class="d-flex align-items-center ms-auto">
            @auth
                <span class="me-3 text-muted small d-none d-sm-inline-flex align-items-center gap-2">
                    <i class="bi bi-person-badge"></i>
                    <span>{{ auth()->user()->name }}</span>
                    <span class="chip-role">{{ auth()->user()->role }}</span>
                </span>
                <form action="{{ route('auth.logout') }}" method="post" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
                <a href="{{ route('auth.register.perawat') }}" class="btn btn-sm btn-success">
                    <i class="bi bi-person-plus me-1"></i> Daftar Perawat
                </a>
            @endauth
        </div>
    </div>
</nav>

<div class="layout-shell">
    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="layout-main">
        @hasSection('sidebar')
            <aside id="sidebar" class="sidebar">
                @yield('sidebar')
            </aside>
        @else
            <aside id="sidebar" class="sidebar collapsed"></aside>
        @endif

        <main id="contentWrapper" class="content-wrapper">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
{{-- SweetAlert2 global --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('btnToggleSidebar');
    var sidebar = document.getElementById('sidebar');
    if(btn && sidebar){
        btn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }
});
</script>
@stack('scripts')
</body>
</html>
