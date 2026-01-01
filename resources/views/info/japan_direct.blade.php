@extends('layouts.app')

@section('title', '日本直送について')

@section('content')
<div class="container my-5">
    <div class="info__container">
        <div class="info__header mb-5">
            <img src="{{ asset('images/06-1.jpg') }}" alt="日本直送について" class="info__header-image">
        </div>
        
        <div class="info__faq">
                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 可以進行船運郵送嗎？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 本網站所有商品都已航空運費計算方式進行概算。同時，我們也對應船運方式的郵送，若您有船運郵送的需要，可以通過客服聊天與我們聯繫。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 關於網站內顯示的商品價格？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 顯示的商品價格每週一更新。當前顯示價格是一周前發出的下一周的預想價格。自動發行的預估報價將以這個價格為基礎進行計算。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 儲存溫度不同的商品可以分開棧板嗎？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 可以。常溫儲存商品和冷藏商品混在一起的情況下，系統上作為同一通關商品時統一碼垛的。但若被判斷為必要情況的話，不僅要分開棧板，我們還可能會與您商討製作多份商品通關文件的事宜。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 正式報價何時發行？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 根據訂單數量，正常情況下于兩個工作日內發行。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 于何時進行支付？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 請于正式報價發行的第二天匯款。若為多次購買的持續性交易客戶，在把一周交易商品的預計金額作為保證金的情況下，可以更快的進行交易。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 進口通關的方式是？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> ①客戶自行辦理進口手續 ②請與中國的貨運代理簽訂合同，辦理進口手續。 ③請與日本貨運的台灣代理店辦理進口手續。 以上所述其中之一。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 發現次品的話怎麼辦？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> Incoterms（國際貿易術語）即是C&F。當商品從各個產地到達日本的倉庫時，會對商品的質量進行質量檢查。從產地發貨到裝船的責任由本公司承擔。裝船後的責任由客戶承擔。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 交貨期延誤的話，會有怎樣的補償呢？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 我們不為延期交貨提供任何補償。 因為我們是客戶與海外生產商之間交涉的業務代理，所以請理解關於補償問題的對應範圍取決於海外生產商。
                    </div>
                </div>

                <div class="info__faq-item">
                    <div class="info__faq-question">
                        <strong>Q：</strong> 進口時需要繳納什麼稅金？
                    </div>
                    <div class="info__faq-answer">
                        <strong>A：</strong> 必須要繳納的是進口稅，大部分情況下關稅也要根據商品的類別進行繳納。 消費稅根據情況，在寄存消費稅和支付消費稅存在差額的情況下可以得到返還，所以通常也可以不包含在成本計算中。
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

