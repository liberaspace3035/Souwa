@extends('layouts.app')

@section('title', '見積書詳細')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>見積書詳細</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('quotations.download', $quotation) }}" class="btn btn-success">PDFダウンロード</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>見積書番号: {{ $quotation->quotation_number }}</h5>
                    <p>作成日: {{ $quotation->quotation_date->format('Y年m月d日') }}</p>
                    @if($quotation->valid_until)
                        <p>有効期限: {{ $quotation->valid_until->format('Y年m月d日') }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    <h5>お客様情報</h5>
                    <p>{{ $quotation->user->name }}</p>
                    <p>{{ $quotation->user->email }}</p>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>商品名</th>
                        <th>単価</th>
                        <th>数量</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotation->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>¥{{ number_format($item->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>¥{{ number_format($item->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">小計</th>
                        <th>¥{{ number_format($quotation->subtotal) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">消費税（10%）</th>
                        <th>¥{{ number_format($quotation->tax) }}</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">合計</th>
                        <th>¥{{ number_format($quotation->total) }}</th>
                    </tr>
                </tfoot>
            </table>

            @if($quotation->notes)
                <div class="mt-4">
                    <h5>備考</h5>
                    <p>{{ $quotation->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection




