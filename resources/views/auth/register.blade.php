@extends('layouts.app')

@section('title', '新規登録')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <img src="{{ asset('images/topsowa.png') }}" alt="SOUWA" class="img-fluid" style="max-width: 100%; height: auto;">
            </div>
            <h2 class="text-center mb-4">請輸入您的信息,註冊成為會員。</h2>

            <div class="shadow-sm">
                <div class="card-body p-5 register-card-body">                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3 row">
                            <label for="name" class="col-md-3 col-form-label">企業名 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="region" class="col-md-3 col-form-label">區域 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <select class="form-select input @error('region') is-invalid @enderror" id="region" name="region" required>
                                    <option value="">選択してください</option>
                                    <option value="香港" {{ old('region') == '香港' ? 'selected' : '' }}>香港</option>
                                    <option value="台灣" {{ old('region') == '台灣' ? 'selected' : '' }}>台灣</option>
                                    <option value="中國大陸" {{ old('region') == '中國大陸' ? 'selected' : '' }}>中國大陸</option>
                                    <option value="マカオ" {{ old('region') == 'マカオ' ? 'selected' : '' }}>マカオ</option>
                                    <option value="シンガポール" {{ old('region') == 'シンガポール' ? 'selected' : '' }}>シンガポール</option>
                                    <option value="その他" {{ old('region') == 'その他' ? 'selected' : '' }}>その他</option>
                                </select>
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="address" class="col-md-3 col-form-label">地址 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <textarea class="form-control input @error('address') is-invalid @enderror" id="address" name="address" rows="2" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phone_number" class="col-md-3 col-form-label">電話號碼 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="tel" class="form-control input @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-3 col-form-label">郵箱 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="email" class="form-control input @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="person_in_charge" class="col-md-3 col-form-label">負責人 <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input @error('person_in_charge') is-invalid @enderror" id="person_in_charge" name="person_in_charge" value="{{ old('person_in_charge') }}" required>
                                @error('person_in_charge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="position" class="col-md-3 col-form-label">職位</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input @error('position') is-invalid @enderror" id="position" name="position" value="{{ old('position') }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="company_size" class="col-md-3 col-form-label">企業規模</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control input @error('company_size') is-invalid @enderror" id="company_size" name="company_size" value="{{ old('company_size') }}" placeholder="例: 10-50人、50-200人等">
                                @error('company_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="company_website" class="col-md-3 col-form-label">企業網址</label>
                            <div class="col-md-9">
                                <input type="url" class="form-control input @error('company_website') is-invalid @enderror" id="company_website" name="company_website" value="{{ old('company_website') }}" placeholder="https://example.com">
                                @error('company_website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-3 col-form-label">パスワード <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control input @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">8文字以上</small>
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password_confirmation" class="col-md-3 col-form-label">パスワード（確認） <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="password" class="form-control input" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-login-submit">註冊會員</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}">ログインはこちら</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
