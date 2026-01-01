<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>見積書 - {{ $quotation->quotation_number }}</title>
    <style>
        @font-face {
            font-family: 'notosansjp';
            font-style: normal;
            font-weight: normal;
        }
        * {
            font-family: 'notosansjp', 'DejaVu Sans', sans-serif;
        }
        body {
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 20px;
        }
        .total-table {
            width: 100%;
            border-collapse: collapse;
        }
        .total-table td {
            padding: 5px;
        }
        .total-table .label {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>見積書</h1>
        <p>SOUWA - 厳選最高品質日本食材</p>
    </div>

    <div class="info-section">
        <table>
            <tr>
                <td width="50%">
                    <strong>見積書番号:</strong> {{ $quotation->quotation_number }}<br>
                    <strong>作成日:</strong> {{ $quotation->quotation_date->format('Y年m月d日') }}<br>
                    @if($quotation->valid_until)
                        <strong>有効期限:</strong> {{ $quotation->valid_until->format('Y年m月d日') }}
                    @endif
                </td>
                <td width="50%">
                    <strong>お客様情報</strong><br>
                    {{ $quotation->user->name }}<br>
                    {{ $quotation->user->email }}
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>商品名</th>
                <th class="text-right">単価</th>
                <th class="text-right">数量</th>
                <th class="text-right">小計</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-right">¥{{ number_format($item->price) }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">¥{{ number_format($item->subtotal) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table class="total-table">
            <tr>
                <td class="label" width="80%">小計</td>
                <td class="text-right">¥{{ number_format($quotation->subtotal) }}</td>
            </tr>
            <tr>
                <td class="label">消費税（10%）</td>
                <td class="text-right">¥{{ number_format($quotation->tax) }}</td>
            </tr>
            <tr>
                <td class="label"><strong>合計</strong></td>
                <td class="text-right"><strong>¥{{ number_format($quotation->total) }}</strong></td>
            </tr>
        </table>
    </div>

    @if($quotation->notes)
        <div style="margin-top: 30px;">
            <strong>備考:</strong><br>
            {{ $quotation->notes }}
        </div>
    @endif

    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #666;">
        <p>SOUWA - 厳選最高品質日本食材 卸売直送</p>
        <p>Email: info@souwa.com</p>
    </div>
</body>
</html>

