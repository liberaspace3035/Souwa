@extends('layouts.app')

@section('title', '商品編集')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">商品編集</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">商品名</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">商品説明</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">価格</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">商品画像</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">カテゴリ</label>
            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                <option value="">選択してください</option>
                <option value="新鮮野菜" {{ old('category', $product->category) == '新鮮野菜' ? 'selected' : '' }}>新鮮野菜</option>
                <option value="美味しい果物" {{ old('category', $product->category) == '美味しい果物' ? 'selected' : '' }}>美味しい果物</option>
                <option value="肉類" {{ old('category', $product->category) == '肉類' ? 'selected' : '' }}>肉類</option>
                <option value="卵・乳製品" {{ old('category', $product->category) == '卵・乳製品' ? 'selected' : '' }}>卵・乳製品</option>
                <option value="蜂蜜・茶類" {{ old('category', $product->category) == '蜂蜜・茶類' ? 'selected' : '' }}>蜂蜜・茶類</option>
                <option value="魚類・海鮮" {{ old('category', $product->category) == '魚類・海鮮' ? 'selected' : '' }}>魚類・海鮮</option>
                <option value="米・穀類" {{ old('category', $product->category) == '米・穀類' ? 'selected' : '' }}>米・穀類</option>
                <option value="調味料・加工品" {{ old('category', $product->category) == '調味料・加工品' ? 'selected' : '' }}>調味料・加工品</option>
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="airport" class="form-label">発送空港</label>
            <select class="form-select @error('airport') is-invalid @enderror" id="airport" name="airport">
                <option value="">選択してください</option>
                <option value="tokyo" {{ old('airport', $product->airport) == 'tokyo' ? 'selected' : '' }}>東京成田/羽田機場</option>
                <option value="osaka" {{ old('airport', $product->airport) == 'osaka' ? 'selected' : '' }}>大阪國際關西機場</option>
                <option value="nagoya" {{ old('airport', $product->airport) == 'nagoya' ? 'selected' : '' }}>名古屋中部國際機場</option>
                <option value="fukuoka" {{ old('airport', $product->airport) == 'fukuoka' ? 'selected' : '' }}>福岡機場</option>
                <option value="hokkaido" {{ old('airport', $product->airport) == 'hokkaido' ? 'selected' : '' }}>北海道新千歲機場</option>
                <option value="okinawa" {{ old('airport', $product->airport) == 'okinawa' ? 'selected' : '' }}>沖繩那霸機場</option>
            </select>
            @error('airport')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">在庫数</label>
            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">おすすめ商品</label>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_limited" name="is_limited" value="1" {{ old('is_limited', $product->is_limited) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_limited">期間限定</label>
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_new">新商品</label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection
