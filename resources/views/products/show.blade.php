@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-image" style="font-size: 5rem; color: #ccc;"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category }}</p>
            <p class="h3 mb-4">¥{{ number_format($product->price) }}</p>
            
            @if($product->description)
                <div class="mb-4">
                    <h5>商品説明</h5>
                    <p>{{ $product->description }}</p>
                </div>
            @endif

            @if($product->stock > 0)
                <p class="text-success">在庫あり</p>
            @else
                <p class="text-danger">在庫なし</p>
            @endif

            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="quantity" class="form-label">数量</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">カートに追加</button>
                    </form>
                @endif
            @else
                <div class="alert alert-info mt-4">
                    カートに追加するには<a href="{{ route('login') }}">ログイン</a>が必要です。
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection


