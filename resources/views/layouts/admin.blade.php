<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title', 'Gestion de Stock')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f8f7fc; }
        a { text-decoration: none; }

        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #2d1b69 0%, #1a0f3c 100%);
            position: fixed;
            top: 0; left: 0;
            overflow-y: auto;
            z-index: 100;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #7c3aed; border-radius: 10px; }

        .sidebar .brand {
            padding: 22px 20px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar .brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 17px; }
        .sidebar .brand small { color: #a78bfa; font-size: 11px; display: block; margin-top: 3px; }

        .nav-section {
            color: #6d4fc2;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 15px 20px 5px;
            font-weight: 700;
        }
        .sidebar a {
            color: #c4b5fd;
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
        .sidebar a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar a.active { background: #7c3aed; color: #fff; box-shadow: 0 4px 12px rgba(124,58,237,0.4); }
        .sidebar a i { width: 18px; text-align: center; }

        .notif-badge {
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 1px 6px;
            font-size: 10px;
            font-weight: bold;
            margin-left: auto;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-footer .user-link {
            background: rgba(255,255,255,0.06);
            border-radius: 10px;
            margin-bottom: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #c4b5fd;
            text-decoration: none;
            transition: all 0.15s;
        }
        .sidebar-footer .user-link:hover { background: rgba(255,255,255,0.12); }
        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #7c3aed, #2d1b69);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 15px;
            flex-shrink: 0;
        }
        .sidebar-footer .user-name { font-size: 13px; font-weight: 600; color: #fff; }
        .sidebar-footer .user-role { font-size: 11px; color: #a78bfa; }
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

        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar {
            background: #fff;
            padding: 14px 24px;
            border-bottom: 1px solid #ede9fe;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }
        .topbar .page-title { font-weight: 700; color: #2d1b69; margin: 0; font-size: 18px; white-space: nowrap; }
        .content-area { padding: 24px; }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid #ede9fe;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(124,58,237,0.06);
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(124,58,237,0.14); }

        .badge-in { background: #dcfce7; color: #166534; padding: 4px 9px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .badge-out { background: #fee2e2; color: #991b1b; padding: 4px 9px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .badge-adjustment { background: #fef9c3; color: #854d0e; padding: 4px 9px; border-radius: 6px; font-size: 12px; font-weight: 600; }

        .btn-primary { background-color: #7c3aed !important; border-color: #7c3aed !important; }
        .btn-primary:hover { background-color: #6d28d9 !important; border-color: #6d28d9 !important; }
        .btn-outline-primary { color: #7c3aed !important; border-color: #7c3aed !important; }
        .btn-outline-primary:hover { background-color: #7c3aed !important; color: #fff !important; }
        .table-light { background-color: #f5f3ff !important; }
        .card { border-radius: 14px !important; }

        .pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.5; } }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #2d1b69;
            cursor: pointer;
            padding: 0;
            flex-shrink: 0;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 99;
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 200;
            }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .menu-toggle { display: block; }
            .topbar { padding: 10px 14px; flex-wrap: wrap; }
            .topbar form { width: 100%; order: 3; }
            .content-area { padding: 16px; }
            .stat-card { padding: 14px; }
        }
    </style>
</head>
<body>

@php
    $low_stock_count    = \App\Models\Product::whereColumn('quantity', '<=', 'alert_quantity')->count();
    $out_of_stock_count = \App\Models\Product::where('quantity', 0)->count();
@endphp

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <h5>📦 StockManager</h5>
        <small>ESPACE ADMIN</small>
    </div>

    <div class="nav-section">Principal</div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    @if($low_stock_count > 0)
    <a href="{{ route('admin.notifications') }}" class="{{ request()->routeIs('admin.notifications') ? 'active' : '' }}" style="background:rgba(239,68,68,0.15);">
        <i class="bi bi-bell-fill text-danger pulse"></i>
        <span class="text-danger">Alertes stock</span>
        <span class="notif-badge">{{ $low_stock_count }}</span>
    </a>
    @endif

    <div class="nav-section">Stock</div>
    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produits
    </a>
    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="bi bi-tags"></i> Catégories
    </a>
    <a href="{{ route('admin.movements.index') }}" class="{{ request()->routeIs('admin.movements.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i> Mouvements
    </a>
    <a href="{{ route('admin.inventories.index') }}" class="{{ request()->routeIs('admin.inventories.*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-check"></i> Inventaires
    </a>

    <div class="nav-section">Gestion</div>
    <a href="{{ route('admin.suppliers.index') }}" class="{{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Fournisseurs
    </a>
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="bi bi-cart3"></i> Commandes
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Employés
    </a>
    <a href="{{ route('admin.clients.index') }}" class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
        <i class="bi bi-person-lines-fill"></i> Clients
    </a>
    <a href="{{ route('admin.invoices.index') }}" class="{{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i> Factures
    </a>
    <a href="{{ route('admin.login_histories.index') }}" class="{{ request()->routeIs('admin.login_histories.*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i> Connexions
    </a>

    <div class="nav-section">Analyse</div>
    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line"></i> Rapports
    </a>
    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <i class="bi bi-gear"></i> Paramètres
    </a>

    <div class="sidebar-footer">
        <a href="{{ route('admin.profile') }}" class="user-link">
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

        {{-- Barre de recherche --}}
        <form method="GET" action="{{ route('admin.search') }}" class="d-flex align-items-center" style="width:280px;">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control border-0 bg-light"
                    placeholder="Rechercher..."
                    value="{{ request('q') }}"
                    autocomplete="off">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>

        <div class="d-flex align-items-center gap-2">
            @if($out_of_stock_count > 0)
                <span class="badge bg-danger pulse d-none d-md-inline">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ $out_of_stock_count }} rupture(s)
                </span>
            @endif
            @if($low_stock_count > 0)
                <a href="{{ route('admin.notifications') }}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-bell me-1"></i>
                    <span class="d-none d-md-inline">{{ $low_stock_count }}</span>
                </a>
            @endif
            <span class="text-muted small d-none d-lg-inline">
                <i class="bi bi-clock me-1"></i>{{ now()->format('d/m/Y H:i') }}
            </span>
        </div>
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