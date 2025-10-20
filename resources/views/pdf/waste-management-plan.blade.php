<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan upravljanja otpadom - {{ $plan->company_name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #2563eb;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header h2 {
            color: #6b7280;
            font-size: 16px;
            margin: 10px 0 0 0;
            font-weight: normal;
        }
        
        .company-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #2563eb;
        }
        
        .company-info h3 {
            color: #1e40af;
            font-size: 16px;
            margin: 0 0 15px 0;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 5px 0;
            color: #374151;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
            color: #111827;
        }
        
        .waste-section {
            margin-bottom: 30px;
        }
        
        .waste-section h3 {
            color: #1e40af;
            font-size: 18px;
            margin: 0 0 15px 0;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        
        .waste-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .waste-table th,
        .waste-table td {
            border: 1px solid #d1d5db;
            padding: 12px;
            text-align: left;
        }
        
        .waste-table th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
        }
        
        .waste-table .quantity {
            text-align: right;
            font-weight: bold;
            color: #2563eb;
        }
        
        .plan-content {
            margin-top: 30px;
        }
        
        .plan-content h2 {
            color: #1e40af;
            font-size: 20px;
            margin: 30px 0 20px 0;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        
        .plan-content h3 {
            color: #374151;
            font-size: 16px;
            margin: 25px 0 15px 0;
        }
        
        .plan-content p {
            margin: 15px 0;
            text-align: justify;
        }
        
        .contract-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .contract-yes {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .contract-no {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Plan upravljanja otpadom</h1>
        <h2>za {{ $plan->company_name }}</h2>
    </div>

    <!-- Company Information -->
    <div class="company-info">
        <h3>Informacije o firmi</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Naziv firme:</div>
                <div class="info-value">{{ $plan->company_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Adresa:</div>
                <div class="info-value">{{ $plan->company_address }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Delatnost:</div>
                <div class="info-value">{{ $plan->business_activity }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Ugovor sa operatorom:</div>
                <div class="info-value">
                    <span class="contract-status {{ $plan->has_contract_with_operator ? 'contract-yes' : 'contract-no' }}">
                        {{ $plan->has_contract_with_operator ? 'Da' : 'Ne' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Datum kreiranja:</div>
                <div class="info-value">{{ $plan->created_at->format('d.m.Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Waste Information -->
    <div class="waste-section">
        <h3>Tipovi i količine otpada</h3>
        <table class="waste-table">
            <thead>
                <tr>
                    <th>Tip otpada</th>
                    <th>Količina mesečno</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plan->waste_types as $wasteType)
                    <tr>
                        <td>{{ $wasteTypes[$wasteType] }}</td>
                        <td class="quantity">{{ $plan->waste_quantities[$wasteType] ?? 0 }} kg</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($plan->notes)
    <!-- Notes Section -->
    <div class="waste-section">
        <h3>Napomene</h3>
        <p>{{ $plan->notes }}</p>
    </div>
    @endif

    <!-- AI Generated Plan -->
    @if($plan->ai_generated_plan)
    <div class="plan-content">
        <h2>Plan upravljanja otpadom</h2>
        {!! nl2br(e($plan->ai_generated_plan)) !!}
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokument generisan {{ now()->format('d.m.Y H:i') }} | Econsalt AI</p>
    </div>
</body>
</html>
