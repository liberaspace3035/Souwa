@extends('layouts.app')

@section('title', '商品一覧')

@section('content')

<div class="products-page">
    <div class="container my-5">
        <!-- ページタイトル -->
        <div class="products-page__header mb-5">
            <h1 class="products-page__title">商品一覧</h1>
            <p class="products-page__subtitle">厳選された最高品質の日本食材をご用意しています</p>
        </div>

        <!-- 検索・フィルターセクション -->
        <div class="products-page__filters mb-4">
            <div class="filter-card">
                <!-- 検索バー -->
                <div class="filter-card__search mb-3">
                    <form method="GET" action="{{ route('products.index') }}" class="search-form">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="bestselling" value="{{ request('bestselling') }}">
                        <input type="hidden" name="new" value="{{ request('new') }}">
                        <input type="hidden" name="limited" value="{{ request('limited') }}">
                        <div class="search-form__wrapper">
                            <i class="bi bi-search search-form__icon"></i>
                            <input 
                                type="text" 
                                class="form-control search-form__input" 
                                name="search" 
                                placeholder="商品名で検索..." 
                                value="{{ request('search') }}"
                            >
                            <button class="btn btn-primary search-form__button" type="submit">
                                <span class="d-none d-md-inline">検索</span>
                                <i class="bi bi-search d-md-none"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- フィルターオプション -->
                <div class="filter-card__options">
                    <!-- カテゴリフィルター -->
                    <div class="filter-option">
                        <label class="filter-option__label">
                            <i class="bi bi-tag-fill"></i>
                            <span>カテゴリ</span>
                        </label>
                        <form method="GET" action="{{ route('products.index') }}" class="filter-form">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="bestselling" value="{{ request('bestselling') }}">
                            <input type="hidden" name="new" value="{{ request('new') }}">
                            <input type="hidden" name="limited" value="{{ request('limited') }}">
                            <select name="category" class="filter-option__select" onchange="this.form.submit()">
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

                    <!-- フィルターバッジ -->
                    <div class="filter-badges">
                        <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="d-none">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <input type="hidden" name="bestselling" value="{{ request('bestselling') ? '1' : '' }}" id="bestsellingInput">
                            <input type="hidden" name="new" value="{{ request('new') ? '1' : '' }}" id="newInput">
                            <input type="hidden" name="limited" value="{{ request('limited') ? '1' : '' }}" id="limitedInput">
                        </form>
                        <button 
                            type="button" 
                            class="filter-badge {{ request('bestselling') ? 'filter-badge--active' : '' }}"
                            onclick="toggleFilter('bestselling')"
                        >
                            <i class="bi bi-star-fill"></i>
                            <span>人気商品</span>
                        </button>
                        <button 
                            type="button" 
                            class="filter-badge {{ request('new') ? 'filter-badge--active' : '' }}"
                            onclick="toggleFilter('new')"
                        >
                            <i class="bi bi-sparkles"></i>
                            <span>新着商品</span>
                        </button>
                        <button 
                            type="button" 
                            class="filter-badge {{ request('limited') ? 'filter-badge--active' : '' }}"
                            onclick="toggleFilter('limited')"
                        >
                            <i class="bi bi-clock-fill"></i>
                            <span>限定商品</span>
                        </button>
                        @if(request('bestselling') || request('new') || request('limited'))
                        <a href="{{ route('products.index', array_filter(['search' => request('search'), 'category' => request('category')])) }}" class="filter-badge filter-badge--clear">
                            <i class="bi bi-x-circle"></i>
                            <span>すべて解除</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- アクティブフィルター表示 -->
            @if(request('search') || request('category') || request('bestselling') || request('new') || request('limited'))
            <div class="active-filters mt-3">
                <span class="active-filters__label">適用中のフィルター:</span>
                @if(request('search'))
                <span class="active-filter-tag">
                    <i class="bi bi-search"></i>
                    検索: "{{ request('search') }}"
                    <a href="{{ route('products.index', array_filter(['category' => request('category'), 'bestselling' => request('bestselling'), 'new' => request('new'), 'limited' => request('limited')])) }}" class="active-filter-tag__remove">
                        <i class="bi bi-x"></i>
                    </a>
                </span>
                @endif
                @if(request('category'))
                <span class="active-filter-tag">
                    <i class="bi bi-tag"></i>
                    カテゴリ: {{ request('category') }}
                    <a href="{{ route('products.index', array_filter(['search' => request('search'), 'bestselling' => request('bestselling'), 'new' => request('new'), 'limited' => request('limited')])) }}" class="active-filter-tag__remove">
                        <i class="bi bi-x"></i>
                    </a>
                </span>
                @endif
                @if(request('bestselling'))
                <span class="active-filter-tag">
                    <i class="bi bi-star-fill"></i>
                    人気商品
                </span>
                @endif
                @if(request('new'))
                <span class="active-filter-tag">
                    <i class="bi bi-sparkles"></i>
                    新着商品
                </span>
                @endif
                @if(request('limited'))
                <span class="active-filter-tag">
                    <i class="bi bi-clock-fill"></i>
                    限定商品
                </span>
                @endif
            </div>
            @endif
        </div>

        <!-- 商品一覧 -->
        <div class="products-page__results">
            @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product->id) }}" class="product-card__link">
                        <!-- 商品画像 -->
                        <div class="product-card__image-wrapper">
                            @if($product->image)
                                <img 
                                    src="{{ asset('storage/' . $product->image) }}" 
                                    class="product-card__image" 
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >
                            @else
                                <div class="product-card__image-placeholder">
                                    <i class="bi bi-image product-card__image-icon"></i>
                                </div>
                            @endif
                            
                            <!-- 商品バッジ -->
                            <div class="product-card__badges">
                                @if(isset($product->is_new) && $product->is_new)
                                <span class="product-badge product-badge--new">
                                    <i class="bi bi-sparkles"></i>
                                    <span>新着</span>
                                </span>
                                @endif
                                @if(isset($product->is_limited) && $product->is_limited)
                                <span class="product-badge product-badge--limited">
                                    <i class="bi bi-clock-fill"></i>
                                    <span>限定</span>
                                </span>
                                @endif
                                @if(isset($product->is_featured) && $product->is_featured)
                                <span class="product-badge product-badge--featured">
                                    <i class="bi bi-star-fill"></i>
                                    <span>人気</span>
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- 商品情報 -->
                        <div class="product-card__body">
                            <h3 class="product-card__title">{{ $product->name }}</h3>
                            @if($product->description)
                            <p class="product-card__description">{{ Str::limit($product->description, 80) }}</p>
                            @endif
                            
                            <div class="product-card__footer">
                                <div class="product-card__price">
                                    <span class="product-card__price-symbol">¥</span>
                                    <span class="product-card__price-amount">{{ number_format($product->price) }}</span>
                                </div>
                                <span class="product-card__action">
                                    詳細を見る
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- ページネーション -->
            <div class="products-page__pagination mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @else
            <!-- 空状態 -->
            <div class="products-page__empty">
                <div class="empty-state">
                    <i class="bi bi-inbox empty-state__icon"></i>
                    <h3 class="empty-state__title">商品が見つかりませんでした</h3>
                    <p class="empty-state__message">
                        @if(request('search') || request('category') || request('bestselling') || request('new') || request('limited'))
                            検索条件を変更してお試しください。
                        @else
                            現在、商品の準備中です。
                        @endif
                    </p>
                    @if(request('search') || request('category') || request('bestselling') || request('new') || request('limited'))
                    <a href="{{ route('products.index') }}" class="btn btn-primary empty-state__button">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        すべてのフィルターを解除
                    </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFilter(type) {
    const form = document.getElementById('filterForm');
    const input = document.getElementById(type + 'Input');
    
    if (input.value === '1') {
        input.value = '';
    } else {
        input.value = '1';
    }
    
    form.submit();
}
</script>
@endpush

@endsection

