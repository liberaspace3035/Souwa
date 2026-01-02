<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SOUWA - 厳選最高品質日本食材')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="header navbar-expand-lg navbar-light">
        <div class="custom-container">
            <div class="d-flex justify-content-between w-100 header__content">
                <!-- 左側: ロゴ -->
                <a class="header__brand" href="{{ auth()->check() ? route('home') : '/' }}">
                    <img src="{{ asset('images/logo.png') }}" alt="SOUWA" class="header__logo">
                </a>
                
                <!-- 右側: トップリンクとアクションボタン -->
                <div class="d-flex flex-column align-items-end">
                    <!-- トップリンク -->
                    <div class="header__top-links d-none d-md-block">
                        <a href="{{ route('info.japan-direct') }}">日本直送について</a>
                        <span class="header__separator">|</span>
                        <a class="header__top-links-text--black" href="{{ route('info.follow') }}">フォローする</a>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/souwajapan/" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://www.instagram.com/souwa.offical/#" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                            <a href="https://www.youtube.com/channel/UCpRVF0xQGoWAvixeuQP8wFg/#" target="_blank" title="YouTube"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                    
                    <!-- アクションボタン -->
                    <div class="header__action-buttons">
                        @auth
                            <div class="dropdown">
                                <a href="#" class="header__action-btn header__action-btn--column dropdown-toggle" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/icon-person.png') }}" alt="ユーザーメニュー" class="header__icon">
                                    <span>{{ auth()->user()->name ?? 'ユーザー' }}</span>
                                    <span class="header__action-btn-text--small">USER<br>MENU</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                                    @if(auth()->user()->isAdmin())
                                        <li><h6 class="dropdown-header">管理メニュー</h6></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam"></i> 商品管理</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.news.index') }}"><i class="bi bi-newspaper"></i> ニュース管理</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-house"></i> ホーム</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> ログアウト</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <span class="button-separator"></span>
                            <a href="{{ route('cart.index') }}" class="header__action-btn header__action-btn--column">
                                <img src="{{ asset('images/icon-cart.png') }}" alt="カート" class="header__icon">
                                <span>カート</span>
                                <span class="header__action-btn-text--small">SHOPPING<br>CART</span>
                                @if(auth()->user()->cartItems()->count() > 0)
                                    <span class="badge bg-danger">{{ auth()->user()->cartItems()->count() }}</span>
                                @endif
                            </a>
                        @else
                            <a href="#" class="header__action-btn header__action-btn--column" data-bs-toggle="modal" data-bs-target="#loginChoiceModal">
                                <img src="{{ asset('images/icon-person.png') }}" alt="ログイン・登録" class="header__icon">
                                <span>ログイン</span>
                                <span class="header__action-btn-text--small">LOGIN&<br>REGISTRATION</span>
                            </a>
                            <span class="button-separator"></span>
                            <a href="{{ route('cart.index') }}" class="header__action-btn header__action-btn--column">
                                <img src="{{ asset('images/icon-cart.png') }}" alt="カート" class="header__icon">
                                <span>カート</span>
                                <span class="header__action-btn-text--small">SHOPPING<br>CART</span>
                            </a>
                        @endauth
                        <span class="button-separator"></span>
                        <a href="{{ route('info.about-sowa') }}" class="header__action-btn header__action-btn--column header__action-btn--about">
                            <img src="{{ asset('images/icon-about.png') }}" alt="SOUWAについて" class="header__icon">
                            <span>SOUWA</span>
                            <span class="header__action-btn-text--small">ABOUT<br>SOUWA</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ヘッダー直下の選択バー -->
    @if(request()->routeIs('home') || request()->is('/'))
    <div class="custom-container">
    <div class="header__selection-bar">
            <div class="header__selection-bar-content">
                <div class="col-md-3">
                    <div class="selection-bar__left-text">
                        <div>精選最優質日本食材</div>
                        <div>批发直送</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="selection-bar__options">
                        <div class="selection-bar__option">
                            <span>選擇發貨機場</span>
                            <button class="selection-bar__circle-btn">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                            <div class="selection-bar__dropdown">
                                <a href="{{ route('airport.show', 'tokyo') }}" class="dropdown-item">東京成田/羽田機場</a>
                                <a href="{{ route('airport.show', 'osaka') }}" class="dropdown-item">大阪國際關西機場</a>
                                <a href="{{ route('airport.show', 'nagoya') }}" class="dropdown-item">名古屋中部國際機場</a>
                                <a href="{{ route('airport.show', 'fukuoka') }}" class="dropdown-item">福岡機場</a>
                                <a href="{{ route('airport.show', 'hokkaido') }}" class="dropdown-item">北海道新千歲機場</a>
                                <a href="{{ route('airport.show', 'okinawa') }}" class="dropdown-item">沖繩那霸機場</a>
                            </div>
                        </div>
                        <div class="selection-bar__separator"></div>
                        <div class="selection-bar__option">
                            <span>選擇食材種類</span>
                            <button class="selection-bar__circle-btn">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                            <div class="selection-bar__dropdown">
                                <a href="{{ route('category.show', 'fresh-vegetables') }}" class="dropdown-item">新鮮野菜</a>
                                <a href="{{ route('category.show', 'fruits') }}" class="dropdown-item">美味しい果物</a>
                                <a href="{{ route('category.show', 'meat') }}" class="dropdown-item">肉類</a>
                                <a href="{{ route('category.show', 'eggs-dairy') }}" class="dropdown-item">卵・乳製品</a>
                                <a href="{{ route('category.show', 'honey-tea') }}" class="dropdown-item">蜂蜜・茶類</a>
                                <a href="{{ route('category.show', 'seafood') }}" class="dropdown-item">魚類・海鮮</a>
                                <a href="{{ route('category.show', 'rice-grains') }}" class="dropdown-item">米・穀類</a>
                                <a href="{{ route('category.show', 'seasonings-processed') }}" class="dropdown-item">調味料・加工品</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <div class="header__logo-small">
                        <img src="{{ asset('images/icon-SOUWA.png') }}" alt="SOUWA" class="header__logo--small">
                    </div>
                </div>
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>
    </div>

    <!-- ログイン/登録選択モーダル -->
    <div class="modal fade" id="loginChoiceModal" tabindex="-1" aria-labelledby="loginChoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-container">
                <div class="modal-body p-5">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <!-- ロゴとタイトル -->
                    <div class="modal__logo-container">
                        <img src="{{ asset('images/logo.png') }}" alt="SOUWA" class="mb-3 modal__logo">
                        <div class="modal__title-container">
                         <h2 class="text-white mb-0 modal__title-text">
                             所以<span class="modal__title-text--highlight">更安心</span>
                         </h2>
                        <h2 class="text-white mb-0 modal__title-text2">
                            因為<span class="modal__title-text--highlight">更了解</span>
                        </h2>
                        </div>
                    </div>

                    <!-- ボタンエリアと入站須知 -->
                    <div class="modal__button">
                        <!-- ボタンエリア -->

                            <div class="modal__button-container">
                                <div class="text-center mb-3 mb-md-0">
                                    <a href="{{ route('register') }}" class="d-inline-block text-decoration-none">
                                        <div class="modal__choice-btn modal__choice-btn--register">
                                            <div>成為會員</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="d-inline-block text-decoration-none">
                                        <div class="modal__choice-btn modal__choice-btn--login">
                                            <div>我是會員</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                        <!-- 入站須知 -->
                        <div class="login-notice-container">
                            <div class="modal__notice">
                                <p class="mb-2">入站須知：
                                </p>
                                <ul class="mb-0">
                                    <li>本網站為會員制日本食材批發商城,成為會員不產生費用。</li>
                                    <li>※網站內不產生金額交易。</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer__content-container">
                <!-- 中央: ロゴ -->
                <div class="col-12 mb-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="footer__logo">
                            <img src="{{ asset('images/logo-footer.png') }}" alt="SOUWA" class="footer__logo-img">
                        </div>
                    </div>
                </div>
                
                <!-- 区切り線 -->
                <div class="col-12 mb-3">
                    <div class="footer__divider"></div>
                </div>
                
                <!-- フッターコンテンツセクション -->
                <div class="col-12 footer__content-grid-container">
                    <div class="footer__content-grid">
                        <!-- 購物流程 -->
                        <div class="footer__content-item">
                            <div class="footer__content-title">購物流程</div>
                        </div>
                        
                        <!-- 常見問題 -->
                        <div class="footer__content-item">
                            <div class="footer__content-title">常見問題</div>
                        </div>
                        
                        <!-- 聯絡客服 -->
                        <div class="footer__content-item">
                            <div class="footer__content-title">聯絡客服</div>
                        </div>
                        
                        <!-- 關注我們 -->
                        <div class="footer__content-item">
                            <div class="footer__content-title">關注我們</div>
                            <div class="footer__social-links">
                                <a href="https://www.facebook.com/souwajapan/" target="_blank" class="footer__social-link">
                                    <i class="bi bi-facebook"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="https://www.instagram.com/souwa.offical/#" target="_blank" class="footer__social-link">
                                    <i class="bi bi-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                                <a href="https://www.youtube.com/channel/UCpRVF0xQGoWAvixeuQP8wFg/#" target="_blank" class="footer__social-link">
                                    <i class="bi bi-youtube"></i>
                                    <span>Youtube</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- 分享好友 -->
                        <div class="footer__content-item">
                            <div class="footer__content-title">分享好友</div>
                            <div class="footer__qr-code">
                                <i class="bi bi-qr-code"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 区切り線 -->
                <div class="col-12 mb-3">
                    <div class="footer__divider"></div>
                </div>
            </div>
            
            <!-- コピーライト -->
            <div class="footer__copyright">
                <p>&copy; {{ date('Y') }} Souwa. 版權所有</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    
    @if(!auth()->check() && ($errors->has('email') || $errors->has('password') || session('error')))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginModalElement = document.getElementById('loginModal');
            if (loginModalElement) {
                var loginModal = new bootstrap.Modal(loginModalElement);
                loginModal.show();
            }
        });
    </script>
    @endif
</body>
</html>

