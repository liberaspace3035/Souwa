@extends('layouts.app')

@section('title', '商品管理')

@section('content')
<div class="admin-page">
    <div class="container my-5">
        <!-- ページヘッダー -->
        <div class="admin-page__header">
            <div class="admin-page__header-content">
                <div class="admin-page__title-section">
                    <h1 class="admin-page__title">
                        商品管理
                    </h1>
                    <p class="admin-page__subtitle">商品の登録・編集・削除を行います</p>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-create">
                    新規登録
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="admin-page__alert alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- 商品一覧テーブル -->
        <div class="admin-page__content">
            @if($products->count() > 0)
            <div class="admin-table">
                <div class="admin-table__header">
                    <div class="admin-table__info">
                        <span>全{{ $products->total() }}件</span>
                    </div>
                </div>
                <div class="admin-table__body">
                    <table class="admin-table__table">
                        <thead>
                            <tr>
                                <th class="admin-table__th admin-table__th--id">ID</th>
                                <th class="admin-table__th admin-table__th--image">画像</th>
                                <th class="admin-table__th admin-table__th--name">商品名</th>
                                <th class="admin-table__th admin-table__th--category">カテゴリ</th>
                                <th class="admin-table__th admin-table__th--airport">発送空港</th>
                                <th class="admin-table__th admin-table__th--price">価格</th>
                                <th class="admin-table__th admin-table__th--stock">在庫</th>
                                <th class="admin-table__th admin-table__th--flags">フラグ</th>
                                <th class="admin-table__th admin-table__th--actions">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="admin-table__row">
                                <td class="admin-table__td admin-table__td--id">{{ $product->id }}</td>
                                <td class="admin-table__td admin-table__td--image">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="admin-table__thumbnail">
                                    @else
                                        <div class="admin-table__thumbnail admin-table__thumbnail--placeholder">
                                        </div>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--name">
                                    <a href="{{ route('products.show', $product->id) }}" class="admin-table__link" target="_blank">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="admin-table__td admin-table__td--category">
                                    @if($product->category)
                                        <span class="admin-table__badge admin-table__badge--category">{{ $product->category }}</span>
                                    @else
                                        <span class="admin-table__empty">-</span>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--airport">
                                    @php
                                        $airportNames = [
                                            'tokyo' => '東京成田/羽田機場',
                                            'osaka' => '大阪國際關西機場',
                                            'nagoya' => '名古屋中部國際機場',
                                            'fukuoka' => '福岡機場',
                                            'hokkaido' => '北海道新千歲機場',
                                            'okinawa' => '沖繩那霸機場',
                                        ];
                                    @endphp
                                    @if($product->airport)
                                        <span class="admin-table__badge admin-table__badge--airport">
                                            {{ $airportNames[$product->airport] ?? $product->airport }}
                                        </span>
                                    @else
                                        <span class="admin-table__empty">-</span>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--price">
                                    <span class="admin-table__price">¥{{ number_format($product->price) }}</span>
                                </td>
                                <td class="admin-table__td admin-table__td--stock">
                                    @if(($product->stock ?? 0) > 0)
                                        <span class="admin-table__stock admin-table__stock--available">{{ $product->stock ?? 0 }}</span>
                                    @else
                                        <span class="admin-table__stock admin-table__stock--unavailable">0</span>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--flags">
                                    <div class="admin-table__flags">
                                        @if($product->is_featured)
                                            <span class="admin-table__flag admin-table__flag--featured" title="おすすめ">おすすめ</span>
                                        @endif
                                        @if($product->is_limited)
                                            <span class="admin-table__flag admin-table__flag--limited" title="期間限定">限定</span>
                                        @endif
                                        @if($product->is_new)
                                            <span class="admin-table__flag admin-table__flag--new" title="新商品">新着</span>
                                        @endif
                                        @if(!$product->is_featured && !$product->is_limited && !$product->is_new)
                                            <span class="admin-table__empty">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="admin-table__td admin-table__td--actions">
                                    <div class="admin-table__actions">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="admin-table__action-btn admin-table__action-btn--edit" title="編集">
                                            編集
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="admin-table__action-form" onsubmit="return confirm('この商品を削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-table__action-btn admin-table__action-btn--delete" title="削除">
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="admin-table__footer">
                    <div class="admin-table__pagination">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="admin-empty">
                <div class="admin-empty__content">
                    <h3 class="admin-empty__title">商品が登録されていません</h3>
                    <p class="admin-empty__message">新規登録ボタンから商品を追加してください</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-create">
                        新規登録
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
