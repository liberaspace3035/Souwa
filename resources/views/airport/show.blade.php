@extends('layouts.app')

@section('title', '發貨機場商品一覽')

@section('content')
<div class="container my-5">
    <div class="mb-4">
        <h1 class="mb-2">發貨機場商品一覽</h1>
        <p class="text-muted">{{ $airportName }}</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('airport.show', $airport) }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="商品名で検索" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">検索</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('airport.show', $airport) }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">すべてのカテゴリ</option>
                    <option value="新鮮野菜" {{ request('category') == '新鮮野菜' ? 'selected' : '' }}>新鮮野菜</option>
                    <option value="美味しい果物" {{ request('category') == '美味しい果物' ? 'selected' : '' }}>美味しい果物</option>
                    <option value="肉類" {{ request('category') == '肉類' ? 'selected' : '' }}>肉類</option>
                    <option value="卵・乳製品" {{ request('category') == '卵・乳製品' ? 'selected' : '' }}>卵・乳製品</option>
                    <option value="蜂蜜・茶類" {{ request('category') == '蜂蜜・茶類' ? 'selected' : '' }}>蜂蜜・茶類</option>
                    <option value="魚類・海鮮" {{ request('category') == '魚類・海鮮' ? 'selected' : '' }}>魚類・海鮮</option>
                    <option value="米・穀類" {{ request('category') == '米・穀類' ? 'selected' : '' }}>米・穀類</option>
                    <option value="調味料・加工品" {{ request('category') == '調味料・加工品' ? 'selected' : '' }}>調味料・加工品</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card product__card h-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product__image" alt="{{ $product->name }}">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center product__image--placeholder">
                        <i class="bi bi-image image-placeholder__icon"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($product->description, 50) }}</p>
                    <p class="card-text"><strong>¥{{ number_format($product->price) }}</strong></p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm">詳細を見る</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">この空港から発送される商品が見つかりませんでした。</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

