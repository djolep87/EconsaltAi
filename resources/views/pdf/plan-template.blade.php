<!DOCTYPE html>
<html>
<head>
    <title>Plan upravljanja otpadom - {{ $companyName }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('fonts/DejaVuSans.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('fonts/DejaVuSans-Bold.ttf') }}') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        
        h1 { 
            font-size: 24px; 
            text-align: center; 
            border-bottom: 2px solid #3498db; 
            padding-bottom: 10px; 
            margin-bottom: 30px;
        }
        
        h2 { 
            font-size: 18px; 
            color: #2980b9;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 5px;
        }
        
        h3 { 
            font-size: 16px; 
            color: #34495e;
        }
        
        h4 { 
            font-size: 14px; 
            color: #7f8c8d;
        }
        
        p {
            margin-bottom: 12px;
            text-align: justify;
        }
        
        ul, ol {
            margin-bottom: 12px;
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }
        
        th, td {
            border: 1px solid #bdc3c7;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .company-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin: 20px 0;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .chapter-separator {
            border-top: 2px solid #3498db;
            margin: 30px 0;
            padding-top: 20px;
        }
        
        .highlight {
            background-color: #fff3cd;
            padding: 10px;
            border-left: 4px solid #ffc107;
            margin: 15px 0;
        }
        
        .warning {
            background-color: #f8d7da;
            padding: 10px;
            border-left: 4px solid #dc3545;
            margin: 15px 0;
        }
        
        .success {
            background-color: #d4edda;
            padding: 10px;
            border-left: 4px solid #28a745;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PLAN UPRAVLJANJA OTPADOM</h1>
        <h2>{{ $companyName }}</h2>
        <p><strong>Generisan:</strong> {{ $generatedAt->format('d.m.Y H:i') }}</p>
    </div>

    <div class="company-info">
        <h3>Osnovni podaci o firmi</h3>
        <p><strong>Naziv firme:</strong> {{ $companyName }}</p>
        <p><strong>Datum generisanja:</strong> {{ $generatedAt->format('d.m.Y H:i') }}</p>
        <p><strong>Verzija dokumenta:</strong> 1.0</p>
    </div>

    <div class="highlight">
        <p><strong>Napomena:</strong> Ovaj dokument je automatski generisan pomoću AI tehnologije u skladu sa zakonima Republike Srbije. Pre korišćenja, preporučuje se dodatna provera i prilagođavanje specifičnim potrebama firme.</p>
    </div>

    <div class="content">
        {!! nl2br(e($content)) !!}
    </div>

    <div class="footer">
        <p>Strana <span class="page-number"></span></p>
        <p>Generisano: {{ $generatedAt->format('d.m.Y H:i') }}</p>
    </div>
</body>
</html>

