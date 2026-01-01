@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/topsowa.png') }}" alt="SOUWA" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
            @if(request()->is('admin/login'))
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">管理者ログイン</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">メールアドレス</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">パスワード</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">ログイン状態を保持する</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">ログイン</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}">一般ユーザーログインはこちら</a>
                    </div>
                </div>
            </div>
            @else
            <h2 class="text-center mb-4">請輸入您的會員ID和登錄密碼。</h2>
            <p class="text-center text-muted mb-4" style="font-size: 0.9rem;">
                如果郵件未收到登錄密碼,可能是管理員還未確認完畢,請稍等。
            </p>
            <div class="shadow-sm login-card">
                <div class="card-body p-5">
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="email" class="col-md-3 col-form-label fw-bold">會員ID <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-3 col-form-label fw-bold">登錄密碼 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control input @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login-submit">登錄</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}">新規登録はこちら</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
