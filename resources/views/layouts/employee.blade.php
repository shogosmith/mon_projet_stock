<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employé — @yield('title', 'Gestion de Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f0fdf4; }
        a { text-decoration: none; }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: linear-gradient(180deg, #134e4a 0%, #042f2e 100%);
            position: fixed;
            top: 0; left: 0;
            overflow-y: auto;
            z-index: 100;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #0d9488; border-radius: 10px; }
        .sidebar .brand {
            padding: 20px 20px 10px;
            border-bottom: 1px solid #0f766e;
        }
        .sidebar .brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 16px; }
        .sidebar .brand small { color: #5eead4; font-size: 11px; display: block; margin-top: 3px; }
        .nav-section {
            color: #0d9488;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 15px 20px 5px;
            font-weight: 700;
        }
        .sidebar a {
            color: #99f6e4;
            text-decoration: none;
            padding: 10px 20px;
            margin: 1px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s;
        }
        .sidebar a:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar a.active { background: #0d9488; color: #fff; box-shadow: 0 4px 12px rgba(13,148,136,0.4); }
        .sidebar a i { width: 18px; text-align: center; }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid #0f766e;
        }
        .sidebar-footer .user-link {
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #99f6e4;
            text-decoration: none;
            transition: all 0.15s;
        }
        .sidebar-footer .user-link:hover { background: rgba(255,255,255,0.12); }
        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #0d9488, #134e4a);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 15px;
            flex-shrink: 0;
        }
        .sidebar-footer .user-name { font-size: 13px; font-weight: 600; color: #fff; }
        .sidebar-footer .user-role { font-size: 11px; color: #5eead4; }
        .sidebar-footer form button {
            width: 100%;
            background: transparent;
            border: 1px solid rgba(239,68,68,0.4);
            color: #fca5a5;
            padding: 9px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.15s;
            cursor: pointer;
        }
        .sidebar-footer form button:hover {
            background: #ef4444;
            border-color: #ef4444;
            color: #fff;
        }

        .main-content { margin-left: 240px; min-height: 100vh; }
        .topbar {
            background: #fff;
            padding: 12px 24px;
            border-bottom: 1px solid #d1fae5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .topbar .page-title { font-weight: 700; color: #134e4a; margin: 0; font-size: 18px; }
        .content-area { padding: 24px; }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #134e4a;
            cursor: pointer;
            padding: 0;
        }

        /* Overlay mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        .sidebar-overlay.show { display: block; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 200;
            }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .menu-toggle { display: block; }
            .topbar { padding: 10px 16px; gap: 10px; }
            .topbar .page-title { font-size: 16px; }
            .content-area { padding: 16px; }
        }
    </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <h5>📦 Mon Espace</h5>
        <small>{{ auth()->user()->name }}</small>
    </div>

    <div class="nav-section">Stock</div>
    <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('employee.products.index') }}" class="{{ request()->routeIs('employee.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produits
    </a>
    <a href="{{ route('employee.movements.create') }}" class="{{ request()->routeIs('employee.movements.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i> Nouveau mouvement
    </a>
    <a href="{{ route('employee.movements.index') }}" class="{{ request()->routeIs('employee.movements.index') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Mes mouvements
    </a>

    <div class="nav-section">Inventaire</div>
    <a href="{{ route('employee.inventories.create') }}" class="{{ request()->routeIs('employee.inventories.create') ? 'active' : '' }}">
        <i class="bi bi-clipboard-plus"></i> Nouvel inventaire
    </a>
    <a href="{{ route('employee.inventories.index') }}" class="{{ request()->routeIs('employee.inventories.index') ? 'active' : '' }}">
        <i class="bi bi-clipboard-check"></i> Mes inventaires
    </a>

    <div class="nav-section">Commandes</div>
    <a href="{{ route('employee.orders.create') }}" class="{{ request()->routeIs('employee.orders.create') ? 'active' : '' }}">
        <i class="bi bi-cart-plus"></i> Nouvelle commande
    </a>
    <a href="{{ route('employee.orders.index') }}" class="{{ request()->routeIs('employee.orders.index') ? 'active' : '' }}">
        <i class="bi bi-cart3"></i> Mes commandes
    </a>

    <div class="sidebar-footer">
        <a href="{{ route('employee.profile') }}" class="user-link">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role"><i class="bi bi-person-gear me-1"></i>Mon profil</div>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>

<div class="main-content">
    <div class="topbar">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="page-title">@yield('title', 'Dashboard')</h1>
        <span class="text-muted small">
            <i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y H:i') }}
        </span>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>
@stack('scripts')
</body>
</html>