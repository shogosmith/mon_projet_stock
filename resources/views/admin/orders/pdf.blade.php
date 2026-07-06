<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande {{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1e293b; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 3px solid #312e81; padding-bottom: 15px; }
        .company-name { font-size: 24px; font-weight: bold; color: #312e81; }
        .company-sub { color: #64748b; font-size: 12px; }
        .order-number { font-size: 18px; font-weight: bold; text-align: right; }
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #dbeafe; color: #1e40af; }
        .badge-received { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .info-grid { display: table; width: 100%; margin-bottom: 25px; }
        .info-box { display: table-cell; width: 50%; vertical-align: top; padding: 15px; background: #f8fafc; border-radius: 8px; }
        .info-box h6 { margin: 0 0 10px; color: #312e81; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .info-box p { margin: 3px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #312e81; color: white; padding: 10px; text-align: left; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        tr:nth-child(even) { background: #f8fafc; }
        .total-row { background: #312e81 !important; color: white; font-weight: bold; }
        .total-row td { color: white; border: none; }
        .footer { margin-top: 40px; padding-top: 15px; border-top: 1px solid #e2e8f0; text-align: center; color: #64748b; font-size: 11px; }
    </style>
</head>
<body>

<div class="header">
    <div>
        <div class="company-name">📦 StockManager</div>
        <div class="company-sub">Système de Gestion de Stock</div>
    </div>
    <div style="text-align:right">
        <div class="order-number">{{ $order->order_number }}</div>
        <div style="margin-top:5px">
            @php
                $badges = ['pending'=>'pending','approved'=>'approved','received'=>'received','cancelled'=>'cancelled'];
                $labels = ['pending'=>'En attente','approved'=>'Approuvée','received'=>'Reçue','cancelled'=>'Annulée'];
            @endphp
            <span class="badge badge-{{ $badges[$order->status] }}">{{ $labels[$order->status] }}</span>
        </div>
        <div style="color:#64748b;font-size:12px;margin-top:5px">
            Date : {{ $order->created_at->format('d/m/Y H:i') }}
        </div>
    </div>
</div>

<div class="info-grid">
    <div class="info-box">
        <h6>Fournisseur</h6>
        @if($order->supplier)
            <p><strong>{{ $order->supplier->name }}</strong></p>
            <p>{{ $order->supplier->email ?? '—' }}</p>
            <p>{{ $order->supplier->phone ?? '—' }}</p>
            <p>{{ $order->supplier->address ?? '—' }}</p>
            <p>{{ $order->supplier->country ?? '—' }}</p>
        @else
            <p>Aucun fournisseur</p>
        @endif
    </div>
    <div style="width:20px; display:table-cell;"></div>
    <div class="info-box">
        <h6>Informations commande</h6>
        <p><strong>N° :</strong> {{ $order->order_number }}</p>
        <p><strong>Créée par :</strong> {{ $order->user->name }}</p>
        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        <p><strong>Notes :</strong> {{ $order->notes ?? '—' }}</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Sous-total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</td>
            <td>{{ number_format($item->quantity * $item->unit_price, 0, ',', ' ') }} FCFA</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="4" style="text-align:right">TOTAL</td>
            <td>{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <p>Document généré le {{ now()->format('d/m/Y à H:i') }} — StockManager</p>
    <p>Ce document est généré automatiquement par le système de gestion de stock.</p>
</div>

</body>
</html>