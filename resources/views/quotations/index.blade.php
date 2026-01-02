@extends('layouts.app')

@section('title', '見積書一覧')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">見積書一覧</h1>

    @if($quotations->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>見積書番号</th>
                        <th>作成日</th>
                        <th>有効期限</th>
                        <th>合計金額</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $quotation)
                    <tr>
                        <td>{{ $quotation->quotation_number }}</td>
                        <td>{{ $quotation->quotation_date->format('Y年m月d日') }}</td>
                        <td>{{ $quotation->valid_until ? $quotation->valid_until->format('Y年m月d日') : '-' }}</td>
                        <td>¥{{ number_format($quotation->total) }}</td>
                        <td>
                            <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-sm btn-primary">詳細</a>
                            <a href="{{ route('quotations.download', $quotation) }}" class="btn btn-sm btn-success">PDFダウンロード</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $quotations->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <p class="lead">見積書がありません。</p>
            <a href="{{ route('cart.index') }}" class="btn btn-primary">カートを見る</a>
        </div>
    @endif
</div>
@endsection




