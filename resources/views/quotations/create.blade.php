@extends('layouts.app')

@section('title', '見積書作成')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">見積書作成</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>カート内容</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>商品名</th>
                                <th>価格</th>
                                <th>数量</th>
                                <th>小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>¥{{ number_format($item->product->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>¥{{ number_format($item->product->price * $item->quantity) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">合計</th>
                                <th>¥{{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; })) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>見積書情報</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotations.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="notes" class="form-label">備考</label>
                            <textarea class="form-control" id="notes" name="notes" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">見積書を作成</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




