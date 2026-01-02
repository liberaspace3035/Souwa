@extends('layouts.app')

@section('title', '選擇食材種類')

@section('content')
<div class="container my-5">
    <div class="mb-4">
        <h1 class="mb-2">選擇食材種類</h1>
        <p class="text-muted">{{ $categoryName }}</p>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('category.show', $category) }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="商品名で検索" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">検索</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('category.show', $category) }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <select name="airport" class="form-select" onchange="this.form.submit()">
                    <option value="">すべての空港</option>
                    <option value="tokyo" {{ request('airport') == 'tokyo' ? 'selected' : '' }}>東京成田/羽田機場</option>
                    <option value="osaka" {{ request('airport') == 'osaka' ? 'selected' : '' }}>大阪國際關西機場</option>
                    <option value="nagoya" {{ request('airport') == 'nagoya' ? 'selected' : '' }}>名古屋中部國際機場</option>
                    <option value="fukuoka" {{ request('airport') == 'fukuoka' ? 'selected' : '' }}>福岡機場</option>
                    <option value="hokkaido" {{ request('airport') == 'hokkaido' ? 'selected' : '' }}>北海道新千歲機場</option>
                    <option value="okinawa" {{ request('airport') == 'okinawa' ? 'selected' : '' }}>沖繩那霸機場</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card product__card h-100">
                @if($product->image)
                    <img src="{{ $product->image_url }}" class="card-img-top product__image" alt="{{ $product->name }}">
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
            <p class="text-center">このカテゴリの商品が見つかりませんでした。</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection


