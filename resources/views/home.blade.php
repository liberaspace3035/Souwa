@extends('layouts.app')

@section('title', 'SOUWA - 厳選最高品質日本食材')

@section('content')
<div class="container-fluid px-0">
    <!-- 上部メインバナーセクション -->
    <div class="hero__section">
        <div class="hero__content">
            <!-- 左側パネル -->
            <div class="hero__left-panel--left">
                <div class="hero__left-panel">
                    <div class="hero__left-content">
                        <!-- 農家の写真 -->
                        <div class="hero__farmer-image">
                            <img src="{{ asset('images/img-top2.png') }}" alt="農家" class="hero__farmer-img">
                            <!-- 下部: 採購須知ボックス（写真の下3分の1に重ねる） -->
                            <div class="hero__purchase-info">
                                <div class="hero__purchase-content">
                                    <div class="hero__purchase-text-wrapper">
                                        <div class="hero__purchase-title">
                                            <h2>採購須知</h2>
                                        </div>
                                        <div class="hero__purchase-text">
                                            本站食材的批發直送僅面向超商、料理店及其他相關團體的大批量採買,暫不面向個人開放購買業務,望請悉知
                                            <i class="bi bi-chevron-right hero__purchase-arrow"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 右側: プロモーションバナー（スライダー） -->
            <div class="hero__slider-section-right">
                <div class="hero__slider">
                    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/img-top2.png') }}" class="d-block w-100 hero__slider-image" alt="スライド1">
                            </div>
                            <!-- 追加のスライドをここに追加可能 -->
                            <div class="carousel-item">
                                <img src="{{ asset('images/img-top2.png') }}" class="d-block w-100 hero__slider-image" alt="スライド2">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 下部: ニュースセクション -->
    <div class="news__section-bottom">
        <div class="container-fluid px-0">
            <div class="news__flex">
                    <div class="news__box--left">
                        <div class="news__box-title">最新情報</div>
                        <div class="news__box-english">NEWS</div>
                        {{-- @if($latestNews)
                            @if($latestNews->link)
                                <a href="{{ $latestNews->link }}" class="news__link">
                                    <div class="news__title">{{ $latestNews->title }}</div>
                                </a>
                            @else
                                <div class="news__title">{{ $latestNews->title }}</div>
                            @endif
                        @endif --}}
                    </div>
                    <div class="news__image--right">
                        @if($latestNews && $latestNews->image)
                            <img src="{{ $latestNews->image_url }}" alt="{{ $latestNews->title }}" class="news__large-image">
                        @else
                            <div class="news__image--placeholder-large">
                                <i class="bi bi-image image-placeholder__icon--large"></i>
                            </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- 生產商們的聲音 (Voices of the Producers) セクション -->
<div class="fullwidth-container">
<div class="producer__voices-section">
    <div class="container">
        <div class="producer__voices-content">
            <div class="producer__voices-header">
                <h2 class="producer__voices-title">\ 生產商們的聲音 /</h2>
                <p class="producer__voices-subtitle">Voices of the Producers</p>
            </div>
            <div class="producer__voices-actions">
                <button class="producer__carousel-arrow-btn producer__arrow--left" type="button">
                    <i class="bi bi-chevron-left producer__carousel-arrow"></i>
                </button>
                <div class="producer__check-more">
                    <span class="check-text">Check</span>
                    <a href="#" class="producer__more-button">
                        點擊這裡查看更多
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <span class="more-text">More!</span>
                </div>
                <button class="producer__carousel-arrow-btn producer__arrow--right" type="button">
                    <i class="bi bi-chevron-right producer__carousel-arrow"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- タブセクションと空港選択 -->
<div class="airport__selection-section">
        <!-- メインタブ -->
        <div class="airport__main-tabs">
            <div class="airport__main-tab airport__main-tab--active">
                查看日本各機場發送食材
            </div>
            <div class="airport__main-tab">
                查看日本各地區生產商
            </div>
        </div>
        
        <!-- 空港選択ボタン -->
        <ul class="airport__buttons-container">
            <li class="airport__button--small airport__button--small--tokyo airport__button--small--active">
                <a href="{{ route('airport.show', 'tokyo') }}" data-airport="tokyo"></a>
                <div class="airport__indicator">▼</div>
            </li>
            <li class="airport__button--small airport__button--small--osaka">
                <a href="{{ route('airport.show', 'osaka') }}" data-airport="osaka"></a>
                <div class="airport__indicator">▼</div>
            </li>
            <li class="airport__button--small airport__button--small--nagoya">
                <a href="{{ route('airport.show', 'nagoya') }}" data-airport="nagoya"></a>
                <div class="airport__indicator">▼</div>
            </li>
            <li class="airport__button--small airport__button--small--fukuoka">
                <a href="{{ route('airport.show', 'fukuoka') }}" data-airport="fukuoka"></a>
                <div class="airport__indicator">▼</div>
            </li>
            <li class="airport__button--small airport__button--small--hokkaido">
                <a href="{{ route('airport.show', 'hokkaido') }}" data-airport="hokkaido"></a>
                <div class="airport__indicator">▼</div>
            </li>
            <li class="airport__button--small airport__button--small--okinawa">
                <a href="{{ route('airport.show', 'okinawa') }}" data-airport="okinawa"></a>
                <div class="airport__indicator">▼</div>
            </li>
        </ul>
</div>
</div>

<div class="main-content__container">
    <!-- メインコンテンツエリア -->
    <div class="main-content__container-flex">
        <!-- 左側: 空港選択カード（縦書き） -->
        <div class="col-12 col-md-4 mb-4">
            <ul class="main-bottom__side">
                <li class="tokyo">
                    <a href="{{ route('airport.show', 'tokyo') }}">東京成田/羽田機場</a>
                </li>
                <li class="osaka">
                    <a href="{{ route('airport.show', 'osaka') }}">大阪國際關西機場</a>
                </li>
                <li class="nagoya">
                    <a href="{{ route('airport.show', 'nagoya') }}">名古屋中部國際機場</a>
                </li>
                <li class="fukuoka">
                    <a href="{{ route('airport.show', 'fukuoka') }}">福岡機場</a>
                </li>
                <li class="hokkaido">
                    <a href="{{ route('airport.show', 'hokkaido') }}">北海道新千歲機場</a>
                </li>
                <li class="okinawa">
                    <a href="{{ route('airport.show', 'okinawa') }}">沖繩那霸機場</a>
                </li>
            </ul>
        </div>
        
        <!-- 右側: 商品セクション -->
        <div class="col-md-8">
            <!-- NEW ITEMS セクション -->
            <section class="product__section--detailed mb-5">
                <div class="d-flex align-items-start">
                    <div class="product__section-content">
                        <div class="section__title-wrapper">
                            <div>
                                <div class="d-flex align-items-end section__title-wrapper--inner">
                                    <h2 class="section__title--small">NEW ITEMS</h2>
                                    <span class="section__title--japanese">新商品</span>
                                </div>
                                <p class="section__description">送和上新了唷!在這裡有日本生產者們最新推出的精品食材</p>
                            </div>
                            <div class="header__logo-small">
                                <img src="{{ asset('images/icon-SOUWA.png') }}" alt="SOUWA" class="header__logo--small">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__section-actions">
                    <span class="check-text">Check</span>
                    <a href="{{ route('products.index', ['new' => true]) }}" class="btn btn-dark btn-sm product__section-actions-button">點擊這裡查看更多 ></a>
                    <span class="more-text">More!</span>
                </div>
            </section>
            
            <!-- PERIOD LIMITED ITEMS セクション -->
            <section class="product__section--detailed mb-5">
                <div class="d-flex align-items-start">
                    <div class="product__section-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="d-flex align-items-end">
                                    <h2 class="section__title--small">PERIOD LIMITED ITEMS</h2>
                                    <span class="section__title--japanese">期間限定商品</span>
                                </div>
                                <p class="section__description">當季最美味的食材奉上!晚了可就搶不到了喔</p>
                            </div>
                            <div class="header__logo-small">
                                <img src="{{ asset('images/icon-SOUWA.png') }}" alt="SOUWA" class="header__logo--small">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__section-actions">
                    <span class="check-text">Check</span>
                    <a href="{{ route('products.index', ['limited' => true]) }}" class="btn btn-dark btn-sm product__section-actions-button">點擊這裡查看更多 ></a>
                    <span class="more-text">More!</span>
                </div>
            </section>
            
            <!-- BEST SELLING ITEMS セクション -->
            <section class="product__section--detailed mb-5">
                <div class="d-flex align-items-start">
                    <div class="product__section-content">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <div class="d-flex align-items-end">
                                    <h2 class="section__title--small">BEST SELLING ITEMS</h2>
                                    <span class="section__title--japanese">人氣商品</span>
                                </div>
                                <p class="section__description">哪款商品最夯 看這裡你就知道!</p>
                            </div>
                            <div class="header__logo-small">
                                <img src="{{ asset('images/icon-SOUWA.png') }}" alt="SOUWA" class="header__logo--small">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__section-actions">
                    <span class="check-text">Check</span>
                    <a href="{{ route('products.index', ['bestselling' => true]) }}" class="btn btn-dark btn-sm product__section-actions-button">點擊這裡查看更多 ></a>
                    <span class="more-text">More!</span>
                </div>
            </section>
        </div>
    </div>
    
    <!-- 下部: 特徴セクション -->
    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="feature__section">
                <img src="{{ asset('images/icon-SOUWA-img.png') }}" alt="SOUWA" class="feature__icon">
                <div class="feature__content">
                    <h4>新鮮食材 快人一步</h4>
                    <p>日本最新最夯食材同步發佈</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature__section">
                <img src="{{ asset('images/icon-SOUWA-img.png') }}" alt="SOUWA" class="feature__icon">
                <div class="feature__content">
                    <h4>海鮮蔬果 安心運送</h4>
                    <p>採用穩定物流讓您不必擔心貨物安全</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="feature__section">
                <img src="{{ asset('images/icon-SOUWA-img.png') }}" alt="SOUWA" class="feature__icon">
                <div class="feature__content">
                    <h4>天天低價 輕鬆購買</h4>
                    <p>眾多折扣商品 高昂代購說byebye</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 空港選択ボタンのクリックイベント
    const airportButtons = document.querySelectorAll('.airport__button--small');
    
    airportButtons.forEach(button => {
        const link = button.querySelector('a');
        
        if (link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // 全てのボタンからactiveクラスを削除
                airportButtons.forEach(btn => {
                    btn.classList.remove('airport__button--small--active');
                });
                
                // クリックされたボタンのli要素にactiveクラスを追加
                button.classList.add('airport__button--small--active');
            });
        }
    });
    
    // メインタブのクリックイベント
    const mainTabs = document.querySelectorAll('.airport__main-tab');
    
    mainTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // 全てのタブからactiveクラスを削除
            mainTabs.forEach(t => {
                t.classList.remove('airport__main-tab--active');
            });
            
            // クリックされたタブにactiveクラスを追加
            this.classList.add('airport__main-tab--active');
        });
    });
});
</script>
@endpush
