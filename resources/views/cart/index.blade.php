@extends('layouts.app')

@section('title', 'ショッピングカート')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">ショッピングカート</h1>

    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $cartItem)
                            <div class="row align-items-center mb-4 pb-4 border-bottom">
                                <div class="col-md-2">
                                    @if($cartItem->product->image)
                                        <img src="{{ asset('storage/' . $cartItem->product->image) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $cartItem->product->name }}"
                                             style="height: 100px; width: 100%; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                             style="height: 100px;">
                                            <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 class="mb-1">{{ $cartItem->product->name }}</h5>
                                    <p class="text-muted mb-1 small">{{ $cartItem->product->category }}</p>
                                    <p class="text-muted mb-0 small">¥{{ number_format($cartItem->product->price) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group" style="max-width: 150px;">
                                            <input type="number" 
                                                   class="form-control" 
                                                   name="quantity" 
                                                   value="{{ $cartItem->quantity }}" 
                                                   min="1" 
                                                   required>
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="mb-1 fw-bold">¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}</p>
                                </div>
                                <div class="col-md-1 text-end">
                                    <form action="{{ route('cart.destroy', $cartItem) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-link text-danger p-0" 
                                                onclick="return confirm('この商品をカートから削除しますか？')">
                                            <i class="bi bi-trash" style="font-size: 1.2rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">合計金額</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>小計:</span>
                            <span>¥{{ number_format($total) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>合計:</strong>
                            <strong class="h5 mb-0">¥{{ number_format($total) }}</strong>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('quotations.create') }}" class="btn btn-primary btn-lg">
                                見積もりを作成
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                買い物を続ける
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                <h5 class="mb-3">カートは空です</h5>
                <p class="text-muted mb-4">商品をカートに追加してください</p>
                <a href="{{ route('home') }}" class="btn btn-primary">商品を見る</a>
            </div>
        </div>
    @endif
</div>
@endsection
