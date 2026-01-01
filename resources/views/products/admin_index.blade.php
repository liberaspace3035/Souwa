@extends('layouts.app')

@section('title', '商品管理')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>商品管理</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> 新規登録
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>画像</th>
                            <th>商品名</th>
                            <th>カテゴリ</th>
                            <th>発送空港</th>
                            <th>価格</th>
                            <th>在庫</th>
                            <th>おすすめ</th>
                            <th>期間限定</th>
                            <th>新商品</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product__thumbnail">
                                @else
                                    <div class="product__thumbnail product__image--placeholder d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image image-placeholder__icon"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category ?? '-' }}</td>
                            <td>
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
                                {{ $product->airport ? ($airportNames[$product->airport] ?? $product->airport) : '-' }}
                            </td>
                            <td>¥{{ number_format($product->price) }}</td>
                            <td>{{ $product->stock ?? 0 }}</td>
                            <td>
                                @if($product->is_featured)
                                    <span class="badge bg-success">✓</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_limited)
                                    <span class="badge bg-warning">✓</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_new)
                                    <span class="badge bg-info">✓</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> 編集
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('この商品を削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> 削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">商品が登録されていません。</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
