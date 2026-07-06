<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; margin: 0; padding: 25px; }

        /* En-tête */
        .header { display: table; width: 100%; margin-bottom: 25px; }
        .header-left { display: table-cell; width: 55%; vertical-align: top; }
        .header-right { display: table-cell; width: 45%; vertical-align: top; text-align: right; }
        .company-logo { max-height: 70px; max-width: 280px; margin-bottom: 8px; }
        .company-name { font-size: 20px; font-weight: bold; color: #2d1b69; margin: 0; }
        .company-slogan { color: #64748b; font-size: 11px; font-style: italic; }
        .company-info { font-size: 11px; color: #475569; line-height: 1.6; margin-top: 6px; }
        .invoice-title { font-size: 28px; font-weight: bold; color: #2d1b69; margin: 0; }
        .invoice-number { font-size: 14px; color: #7c3aed; font-weight: bold; }
        .invoice-date { font-size: 11px; color: #64748b; margin-top: 4px; }

        /* Badges statut */
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-draft { background: #f1f5f9; color: #475569; }
        .badge-sent { background: #dbeafe; color: #1e40af; }
        .badge-paid { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Ligne séparatrice */
        .divider { border: none; border-top: 3px solid #2d1b69; margin: 15px 0; }

        /* Infos client et commande */
        .info-section { display: table; width: 100%; margin-bottom: 20px; }
        .info-box { display: table-cell; width: 48%; vertical-align: top; padding: 12px 15px; border-radius: 8px; }
        .info-box-left { background: #f8fafc; border-left: 4px solid #2d1b69; }
        .info-box-right { background: #faf5ff; border-left: 4px solid #7c3aed; }
        .info-spacer { display: table-cell; width: 4%; }
        .info-box h6 { margin: 0 0 8px; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .info-box-left h6 { color: #2d1b69; }
        .info-box-right h6 { color: #7c3aed; }
        .info-box p { margin: 2px 0; font-size: 12px; color: #374151; }

        /* Table articles */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table-header th { background: #2d1b69; color: white; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        .table-header th:last-child { text-align: right; }
        td { padding: 10px 12px; border-bottom: 1px solid #e2e8f0; font-size: 12px; }
        td:last-child { text-align: right; font-weight: bold; }
        tr:nth-child(even) td { background: #f8fafc; }

        /* Total */
        .total-section { width: 260px; margin-left: auto; margin-bottom: 20px; }
        .total-line { display: table; width: 100%; padding: 5px 0; }
        .total-label { display: table-cell; color: #64748b; font-size: 12px; }
        .total-value { display: table-cell; text-align: right; font-size: 12px; }
        .total-final-line { display: table; width: 100%; padding: 10px 0; border-top: 2px solid #2d1b69; margin-top: 5px; }
        .total-final-label { display: table-cell; font-weight: bold; font-size: 15px; color: #2d1b69; }
        .total-final-value { display: table-cell; text-align: right; font-weight: bold; font-size: 15px; color: #2d1b69; }

        /* Cachet et signature */
        .stamp-section { display: table; width: 100%; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 15px; }
        .stamp-left { display: table-cell; width: 50%; vertical-align: top; }
        .stamp-right { display: table-cell; width: 50%; vertical-align: top; text-align: right; }
        .stamp-title { font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .stamp-img { max-height: 100px; max-width: 180px; opacity: 0.9; }
        .signature-box { border: 1px dashed #cbd5e1; height: 80px; width: 200px; margin-left: auto; border-radius: 6px; display: flex; align-items: center; justify-content: center; }

        /* Mentions légales */
        .legal-box { background: #f8fafc; border-radius: 8px; padding: 12px 15px; margin-top: 15px; font-size: 10px; color: #64748b; line-height: 1.5; }

        /* Pied de page */
        .footer { margin-top: 20px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

@php
    $settings = \App\Models\CompanySetting::getSettings();
    $badges = ['draft'=>'draft','sent'=>'sent','paid'=>'paid','cancelled'=>'cancelled'];
    $labels = ['draft'=>'Brouillon','sent'=>'Envoyée','paid'=>'Payée','cancelled'=>'Annulée'];
@endphp

{{-- EN-TÊTE --}}
<div class="header">
    <div class="header-left">
        @if($settings->logo)
            <img src="{{ public_path('storage/' . $settings->logo) }}" class="company-logo">
            <br>
        @endif
        <div class="company-name">{{ $settings->company_name }}</div>
        @if($settings->slogan)
            <div class="company-slogan">{{ $settings->slogan }}</div>
        @endif
        <div class="company-info">
            @if($settings->address) {{ $settings->address }}<br>@endif
            @if($settings->city || $settings->country) {{ $settings->city }}{{ $settings->city && $settings->country ? ', ' : '' }}{{ $settings->country }}<br>@endif
            @if($settings->phone) Tél : {{ $settings->phone }}@if($settings->phone2) / {{ $settings->phone2 }}@endif<br>@endif
            @if($settings->email) Email : {{ $settings->email }}<br>@endif
            @if($settings->website) Web : {{ $settings->website }}<br>@endif
            @if($settings->rccm) RCCM : {{ $settings->rccm }}<br>@endif
            @if($settings->ifu) IFU : {{ $settings->ifu }}@endif
        </div>
    </div>
    <div class="header-right">
        <div class="invoice-title">FACTURE</div>
        <div class="invoice-number">{{ $invoice->invoice_number }}</div>
        <div class="invoice-date">
            Date : {{ $invoice->created_at->format('d/m/Y') }}<br>
            @if($invoice->due_date)
                Échéance : {{ $invoice->due_date->format('d/m/Y') }}<br>
            @endif
        </div>
        <div style="margin-top:8px">
            <span class="badge badge-{{ $badges[$invoice->status] }}">
                {{ $labels[$invoice->status] }}
            </span>
        </div>
    </div>
</div>

<hr class="divider">

{{-- INFOS CLIENT ET COMMANDE --}}
<div class="info-section">
    <div class="info-box info-box-left">
        <h6>Facturé à</h6>
        @if($invoice->client)
            <p><strong>{{ $invoice->client->name }}</strong></p>
            @if($invoice->client->email)<p>{{ $invoice->client->email }}</p>@endif
            @if($invoice->client->phone)<p>Tél : {{ $invoice->client->phone }}</p>@endif
            @if($invoice->client->address)<p>{{ $invoice->client->address }}</p>@endif
            @if($invoice->client->country)<p>{{ $invoice->client->country }}</p>@endif
        @else
            <p>Client anonyme</p>
        @endif
    </div>
    <div class="info-spacer"></div>
    <div class="info-box info-box-right">
        <h6>Détails de la facture</h6>
        <p><strong>N° :</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Date :</strong> {{ $invoice->created_at->format('d/m/Y') }}</p>
        @if($invoice->due_date)
            <p><strong>Échéance :</strong> {{ $invoice->due_date->format('d/m/Y') }}</p>
        @endif
        <p><strong>Émis par :</strong> {{ $invoice->user->name }}</p>
        @if($invoice->notes)<p><strong>Réf :</strong> {{ $invoice->notes }}</p>@endif
    </div>
</div>

{{-- TABLEAU DES ARTICLES --}}
<table>
    <thead class="table-header">
        <tr>
            <th style="width:5%">#</th>
            <th style="width:40%">Désignation</th>
            <th style="width:15%;text-align:center">Quantité</th>
            <th style="width:20%;text-align:right">Prix unitaire</th>
            <th style="width:20%">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoice->items as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->description ?? $item->product->name }}</td>
            <td style="text-align:center">{{ $item->quantity }}</td>
            <td style="text-align:right">{{ number_format($item->unit_price, 0, ',', ' ') }} {{ $settings->currency }}</td>
            <td>{{ number_format($item->total, 0, ',', ' ') }} {{ $settings->currency }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- TOTAUX --}}
<div class="total-section">
    <div class="total-line">
        <div class="total-label">Sous-total HT</div>
        <div class="total-value">{{ number_format($invoice->subtotal, 0, ',', ' ') }} {{ $settings->currency }}</div>
    </div>
    <div class="total-line">
        <div class="total-label">TVA / Taxes</div>
        <div class="total-value">{{ number_format($invoice->tax, 0, ',', ' ') }} {{ $settings->currency }}</div>
    </div>
    <div class="total-final-line">
        <div class="total-final-label">TOTAL TTC</div>
        <div class="total-final-value">{{ number_format($invoice->total, 0, ',', ' ') }} {{ $settings->currency }}</div>
    </div>
</div>

{{-- CACHET ET SIGNATURE --}}
<div class="stamp-section">
    <div class="stamp-left">
        <div class="stamp-title">Cachet et signature de l'entreprise</div>
        @if($settings->stamp)
            <img src="{{ public_path('storage/' . $settings->stamp) }}" class="stamp-img">
        @else
            <div style="border: 2px dashed #cbd5e1; height:90px; width:180px; border-radius:8px; display:flex; align-items:center; justify-content:center; color:#94a3b8; font-size:11px;">
                Cachet entreprise
            </div>
        @endif
    </div>
    <div class="stamp-right">
        <div class="stamp-title">Signature du client</div>
        <div class="signature-box">
            <span style="color:#cbd5e1; font-size:11px;">Signature</span>
        </div>
    </div>
</div>

{{-- MENTIONS LÉGALES --}}
@if($settings->invoice_footer || $settings->rccm || $settings->ifu)
<div class="legal-box">
    @if($settings->invoice_footer)
        <p style="margin:0 0 4px">{{ $settings->invoice_footer }}</p>
    @endif
    @if($settings->rccm || $settings->ifu)
        <p style="margin:0">
            @if($settings->rccm) RCCM : {{ $settings->rccm }} @endif
            @if($settings->rccm && $settings->ifu) — @endif
            @if($settings->ifu) IFU : {{ $settings->ifu }} @endif
        </p>
    @endif
</div>
@endif

{{-- PIED DE PAGE --}}
<div class="footer">
    {{ $settings->company_name }}
    @if($settings->phone) — Tél : {{ $settings->phone }} @endif
    @if($settings->email) — {{ $settings->email }} @endif
    <br>Document généré le {{ now()->format('d/m/Y à H:i') }} par StockManager
</div>

</body>
</html>