@extends('layouts.app')

@section('title', 'ABOUT SOUWA')

@section('content')
<div class="container my-5">
    <div class="about-sowa__header">
        <img src="{{ asset('images/03-1.jpg') }}" alt="ABOUT SOUWA" class="about-sowa__header-image">
    </div>
    
    <div class="about-sowa__header mb-5">
        <img src="{{ asset('images/03-2.jpg') }}" alt="ABOUT SOUWA" class="about-sowa__header-image2">
    </div>

    <!-- タイトル部分 -->
    <div class="about-sowa__intro">
        <h2 class="about-sowa__intro-title text"><span>全部食材MADE IN JAPAN!</span></h2>
        <h2 class="about-sowa__intro-title text"><span>豐富的廠家直送商品!</span></h2>
        <h2 class="about-sowa__intro-title text"><span>以最經濟的機場爲基礎選定商品!</span></h2>
    </div>
    <div class="info__container">
        
        <div class="about-sowa__content">
            <!-- 購買方法セクション -->
            <div class="about-sowa__purchase-method">
                <div class="about-sowa__purchase-method-wrapper">
                    <h3 class="about-sowa__section-title">購買方法</h3>
                </div>
                
                <div class="about-sowa__steps">
                    <div class="about-sowa__step-row">
                        <div class="about-sowa__step-number-box">
                            <div class="about-sowa__step-number">1.</div>
                            <div class="about-sowa__step-label">選擇髮貨機場</div>
                        </div>
                        <div class="about-sowa__step-description">
                            【送和】食材的郵送費用計算以髮貨機場的規定爲基準。不同機場髮貨的食材，物流費用會大幅增加，所以<strong>選擇同一機場髮貨的食材會更加劃算喔！</strong>
                        </div>
                    </div>

                    <div class="about-sowa__step-row">
                        <div class="about-sowa__step-number-box">
                            <div class="about-sowa__step-number">2.</div>
                            <div class="about-sowa__step-label">選擇心儀食材</div>
                        </div>
                        <div class="about-sowa__step-description">
                            【送和】食材以"組"爲單位。下單時請注意最小訂購數，若<strong>未達到最小訂購數則無法購買。</strong>
                        </div>
                    </div>

                    <div class="about-sowa__step-row">
                        <div class="about-sowa__step-number-box">
                            <div class="about-sowa__step-number">3.</div>
                            <div class="about-sowa__step-label">下單並等待回執</div>
                        </div>
                        <div class="about-sowa__step-description">
                            【送和】小程序內並不髮生金錢交易。在下單後，您的訂購商品信息會髮送到我們的管理平颱，之後<strong>我們會派專人聯繫您並將正式報價單髮送至您的郵箱。</strong>
                        </div>
                    </div>

                    <div class="about-sowa__step-row">
                        <div class="about-sowa__step-number-box">
                            <div class="about-sowa__step-number">4.</div>
                            <div class="about-sowa__step-label">匯款/交易成功</div>
                        </div>
                        <div class="about-sowa__step-description">
                            <strong>在您確認好報價單後，請於報價單髮行的二天內進行匯款。</strong>在我們確認好金額後會進行髮貨。儘情享受日本的高品質食材吧！
                        </div>
                    </div>
                </div>
            </div>
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

