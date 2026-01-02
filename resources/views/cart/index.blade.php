@extends('layouts.app')

@section('title', 'ショッピングカート')

@section('content')
<div class="cart-page">
    <div class="container my-5">
        <!-- ページヘッダー -->
        <div class="cart-page__header mb-5">
            <h1 class="cart-page__title">ショッピングカート</h1>
            <p class="cart-page__subtitle">{{ $cartItems->count() }}点の商品</p>
        </div>

        @if($cartItems->count() > 0)
        <div class="row">
            <!-- カートアイテム一覧 -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="cart-items">
                    @foreach($cartItems as $cartItem)
                    <div class="cart-item">
                        <!-- 商品画像 -->
                        <div class="cart-item__image-wrapper">
                            @if($cartItem->product->image)
                                <img 
                                    src="{{ $cartItem->product->image_url }}" 
                                    class="cart-item__image" 
                                    alt="{{ $cartItem->product->name }}"
                                    loading="lazy"
                                >
                            @else
                                <div class="cart-item__image-placeholder">
                                    <i class="bi bi-image cart-item__image-icon"></i>
                                </div>
                            @endif
                        </div>

                        <!-- 商品情報 -->
                        <div class="cart-item__info">
                            <h3 class="cart-item__name">
                                <a href="{{ route('products.show', $cartItem->product->id) }}" class="cart-item__name-link">
                                    {{ $cartItem->product->name }}
                                </a>
                            </h3>
                            @if($cartItem->product->category)
                            <div class="cart-item__category">
                                <i class="bi bi-tag-fill"></i>
                                <span>{{ $cartItem->product->category }}</span>
                            </div>
                            @endif
                            <div class="cart-item__price">
                                <span class="cart-item__price-label">単価:</span>
                                <span class="cart-item__price-value">¥{{ number_format($cartItem->product->price) }}</span>
                            </div>
                        </div>

                        <!-- 数量入力 -->
                        <div class="cart-item__quantity">
                            <label class="cart-item__quantity-label">数量</label>
                            <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="cart-item__quantity-form">
                                @csrf
                                @method('PUT')
                                <div class="quantity-input-wrapper">
                                    <button type="button" class="quantity-btn quantity-btn--minus" onclick="decreaseQuantity(this, {{ $cartItem->product->stock }})">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input 
                                        type="number" 
                                        class="form-control quantity-input" 
                                        name="quantity" 
                                        value="{{ $cartItem->quantity }}" 
                                        min="1" 
                                        max="{{ $cartItem->product->stock }}"
                                        required
                                        onchange="this.form.submit()"
                                        onblur="validateQuantity(this, {{ $cartItem->product->stock }})"
                                    >
                                    <button type="button" class="quantity-btn quantity-btn--plus" onclick="increaseQuantity(this, {{ $cartItem->product->stock }})">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- 小計 -->
                        <div class="cart-item__subtotal">
                            <div class="cart-item__subtotal-label">小計</div>
                            <div class="cart-item__subtotal-value">
                                ¥{{ number_format($cartItem->product->price * $cartItem->quantity) }}
                            </div>
                        </div>

                        <!-- 削除ボタン -->
                        <div class="cart-item__actions">
                            <form action="{{ route('cart.destroy', $cartItem) }}" method="POST" class="cart-item__delete-form">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="cart-item__delete-btn"
                                    onclick="return confirm('この商品をカートから削除しますか？')"
                                    title="カートから削除"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- 合計・アクション -->
            <div class="col-lg-4">
                <div class="cart-summary">
                    <div class="cart-summary__header">
                        <h3 class="cart-summary__title">合計金額</h3>
                    </div>
                    <div class="cart-summary__body">
                        <div class="cart-summary__row">
                            <span class="cart-summary__label">小計（{{ $cartItems->count() }}点）:</span>
                            <span class="cart-summary__value">¥{{ number_format($total) }}</span>
                        </div>
                        <div class="cart-summary__divider"></div>
                        <div class="cart-summary__total">
                            <span class="cart-summary__total-label">合計:</span>
                            <span class="cart-summary__total-value">
                                <span class="cart-summary__total-symbol">¥</span>
                                {{ number_format($total) }}
                            </span>
                        </div>
                    </div>
                    <div class="cart-summary__actions">
                        <a href="{{ route('quotations.create') }}" class="btn btn-create-quotation">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>見積もりを作成</span>
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-continue-shopping">
                            <i class="bi bi-arrow-left"></i>
                            <span>買い物を続ける</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- 空のカート -->
        <div class="cart-empty">
            <div class="cart-empty__content">
                <i class="bi bi-cart-x cart-empty__icon"></i>
                <h3 class="cart-empty__title">カートは空です</h3>
                <p class="cart-empty__message">商品をカートに追加して、見積もりを作成しましょう</p>
                <a href="{{ route('home') }}" class="btn btn-browse-products">
                    <i class="bi bi-shop"></i>
                    <span>商品を見る</span>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function increaseQuantity(button, maxStock) {
    const form = button.closest('form');
    const input = form.querySelector('.quantity-input');
    const current = parseInt(input.value) || 1;
    if (current < maxStock) {
        input.value = current + 1;
        input.dispatchEvent(new Event('change'));
    }
}

function decreaseQuantity(button, maxStock) {
    const form = button.closest('form');
    const input = form.querySelector('.quantity-input');
    const current = parseInt(input.value) || 1;
    if (current > 1) {
        input.value = current - 1;
        input.dispatchEvent(new Event('change'));
    }
}

function validateQuantity(input, maxStock) {
    const min = parseInt(input.getAttribute('min'));
    let value = parseInt(input.value) || min;
    
    if (value > maxStock) {
        value = maxStock;
        alert(`在庫が${maxStock}点のみです。`);
    } else if (value < min) {
        value = min;
    }
    
    if (value !== parseInt(input.value)) {
        input.value = value;
        input.form.submit();
    }
}
</script>
@endpush

@endsection
