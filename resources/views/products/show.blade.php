@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-detail-page">
    <div class="container my-5">
        <!-- パンくずリスト / 戻るボタン -->
        <div class="product-detail-page__navigation mb-4">
            <a href="{{ route('products.index') }}" class="product-detail-page__back-link">
                <i class="bi bi-arrow-left"></i>
                <span>商品一覧に戻る</span>
            </a>
        </div>

        <div class="row">
            <!-- 商品画像 -->
            <div class="col-lg-6 col-md-6 mb-4 mb-lg-0">
                <div class="product-detail-page__image-wrapper">
                    @if($product->image)
                        <img 
                            src="{{ $product->image_url }}" 
                            class="product-detail-page__image" 
                            alt="{{ $product->name }}"
                            id="productImage"
                        >
                    @else
                        <div class="product-detail-page__image-placeholder">
                            <i class="bi bi-image product-detail-page__image-icon"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 商品情報 -->
            <div class="col-lg-6 col-md-6">
                <div class="product-detail-page__info">
                    <!-- 商品バッジ -->
                    <div class="product-detail-page__badges mb-3">
                        @if($product->is_new)
                        <span class="product-badge product-badge--new">
                            <i class="bi bi-sparkles"></i>
                            <span>新着</span>
                        </span>
                        @endif
                        @if($product->is_limited)
                        <span class="product-badge product-badge--limited">
                            <i class="bi bi-clock-fill"></i>
                            <span>限定</span>
                        </span>
                        @endif
                        @if($product->is_featured)
                        <span class="product-badge product-badge--featured">
                            <i class="bi bi-star-fill"></i>
                            <span>人気</span>
                        </span>
                        @endif
                    </div>

                    <!-- 商品名 -->
                    <h1 class="product-detail-page__title">{{ $product->name }}</h1>

                    <!-- カテゴリ -->
                    @if($product->category)
                    <div class="product-detail-page__category mb-3">
                        <i class="bi bi-tag-fill"></i>
                        <span>{{ $product->category }}</span>
                    </div>
                    @endif

                    <!-- 価格 -->
                    <div class="product-detail-page__price mb-4">
                        <span class="product-detail-page__price-symbol">¥</span>
                        <span class="product-detail-page__price-amount">{{ number_format($product->price) }}</span>
                    </div>

                    <!-- 在庫状況 -->
                    <div class="product-detail-page__stock mb-4">
                        @if($product->stock > 0)
                        <span class="stock-badge stock-badge--available">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>在庫あり</span>
                            @if($product->stock <= 10)
                            <span class="stock-badge__warning">（残り{{ $product->stock }}点）</span>
                            @endif
                        </span>
                        @else
                        <span class="stock-badge stock-badge--unavailable">
                            <i class="bi bi-x-circle-fill"></i>
                            <span>在庫なし</span>
                        </span>
                        @endif
                    </div>

                    <!-- 商品説明 -->
                    @if($product->description)
                    <div class="product-detail-page__description mb-4">
                        <h3 class="product-detail-page__section-title">商品説明</h3>
                        <div class="product-detail-page__description-content">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    @endif

                    <!-- 空港情報 -->
                    @if($product->airport)
                    <div class="product-detail-page__airport mb-4">
                        <h3 class="product-detail-page__section-title">発送空港</h3>
                        <div class="product-detail-page__airport-content">
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>{{ $product->airport }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- カート追加フォーム -->
                    @auth
                        @if($product->stock > 0)
                        <div class="product-detail-page__cart-section">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="product-detail-page__cart-form">
                                @csrf
                                <div class="product-detail-page__quantity-wrapper">
                                    <label for="quantity" class="product-detail-page__quantity-label">
                                        <i class="bi bi-cart-plus"></i>
                                        <span>数量</span>
                                    </label>
                                    <div class="quantity-input-wrapper">
                                        <button type="button" class="quantity-btn quantity-btn--minus" onclick="decreaseQuantity()">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input 
                                            type="number" 
                                            class="form-control quantity-input" 
                                            id="quantity" 
                                            name="quantity" 
                                            value="1" 
                                            min="1" 
                                            max="{{ $product->stock }}" 
                                            required
                                            onchange="validateQuantity(this)"
                                        >
                                        <button type="button" class="quantity-btn quantity-btn--plus" onclick="increaseQuantity()">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                    <span class="quantity-max">（最大: {{ $product->stock }}）</span>
                                </div>
                                <button type="submit" class="btn btn-add-to-cart">
                                    <i class="bi bi-cart-plus"></i>
                                    <span>カートに追加</span>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="product-detail-page__unavailable">
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>現在在庫がございません</span>
                            </div>
                        </div>
                        @endif
                    @else
                    <div class="product-detail-page__login-required">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>カートに追加するには</span>
                            <a href="{{ route('login') }}" class="alert-link">ログイン</a>
                            <span>が必要です</span>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function increaseQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const current = parseInt(input.value) || 1;
    if (current < max) {
        input.value = current + 1;
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const current = parseInt(input.value) || 1;
    if (current > 1) {
        input.value = current - 1;
    }
}

function validateQuantity(input) {
    const max = parseInt(input.getAttribute('max'));
    const min = parseInt(input.getAttribute('min'));
    let value = parseInt(input.value) || min;
    
    if (value > max) {
        value = max;
    } else if (value < min) {
        value = min;
    }
    
    input.value = value;
}
</script>
@endpush

@endsection


