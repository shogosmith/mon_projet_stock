<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Stock</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; margin: 0; padding: 20px; }
        .header { border-bottom: 3px solid #2d1b69; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #2d1b69; font-size: 22px; margin: 0; }
        .header p { color: #64748b; font-size: 11px; margin: 4px 0 0; }
        .stats { display: table; width: 100%; margin-bottom: 20px; }
        .stat-box { display: table-cell; width: 33%; padding: 12px; background: #f8fafc; border-radius: 8px; text-align: center; }
        .stat-box .val { font-size: 20px; font-weight: bold; color: #2d1b69; }
        .stat-box .lab { font-size: 10px; color: #64748b; text-transform: uppercase; }
        .spacer { display: table-cell; width: 2%; }
        h2 { color: #2d1b69; font-size: 14px; border-bottom: 2px solid #ede9fe; padding-bottom: 5px; margin: 20px 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #2d1b69; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .badge-ok { background: #dcfce7; color: #166534; padding: 2px 7px; border-radius: 4px; font-size: 10px; }
        .badge-low { background: #fee2e2; color: #991b1b; padding: 2px 7px; border-radius: 4px; font-size: 10px; }
        .footer { margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 10px; text-align: center; color: #94a3b8; font-size: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h1>📦 StockManager — Rapport de Stock</h1>
    <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
</div>

<div class="stats">
    <div class="stat-box">
        <div class="val">{{ $products->count() }}</div>
        <div class="lab">Total produits</div>
    </div>
    <div class="spacer"></div>
    <div class="stat-box">
        <div class="val">{{ number_format($total_value, 0, ',', ' ') }} F</div>
        <div class="lab">Valeur totale du stock</div>
    </div>
    <div class="spacer"></div>
    <div class="stat-box">
        <div class="val" style="color:#ef4444">{{ $low_stock->count() }}</div>
        <div class="lab">Produits stock faible</div>
    </div>
</div>

<h2>Liste complète des produits</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Produit</th>
            <th>Référence</th>
            <th>Catégorie</th>
            <th>Fournisseur</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Seuil</th>
            <th>Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $p->name }}</strong></td>
            <td>{{ $p->reference }}</td>
            <td>{{ $p->category->name ?? '—' }}</td>
            <td>{{ $p->supplier->name ?? '—' }}</td>
            <td>{{ number_format($p->price, 0, ',', ' ') }} F</td>
            <td><strong>{{ $p->quantity }}</strong></td>
            <td>{{ $p->alert_quantity }}</td>
            <td>
                @if($p->isLowStock())
                    <span class="badge-low">Faible</span>
                @else
                    <span class="badge-ok">OK</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@if($low_stock->count() > 0)
<h2 style="color:#ef4444">Produits sous le seuil d'alerte</h2>
<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Stock actuel</th>
            <th>Seuil</th>
            <th>Manquant</th>
        </tr>
    </thead>
    <tbody>
        @foreach($low_stock as $p)
        <tr>
            <td><strong>{{ $p->name }}</strong></td>
            <td style="color:#ef4444"><strong>{{ $p->quantity }}</strong></td>
            <td>{{ $p->alert_quantity }}</td>
            <td style="color:#ef4444">{{ $p->alert_quantity - $p->quantity }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="footer">
    StockManager — Rapport généré automatiquement le {{ now()->format('d/m/Y à H:i') }}
</div>

</body>
</html>