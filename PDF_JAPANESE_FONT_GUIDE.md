# PDF日本語フォント設定ガイド

## 目次
1. [問題の概要](#問題の概要)
2. [原因の詳細](#原因の詳細)
3. [解決方法](#解決方法)
4. [設定ファイルの確認](#設定ファイルの確認)
5. [トラブルシューティング](#トラブルシューティング)

---

## 問題の概要

### 発生していた問題
PDFを生成した際に、日本語文字（ひらがな、カタカナ、漢字）が「？」として表示される文字化けが発生していました。

### 影響範囲
- 見積書PDF内のすべての日本語テキスト
- タイトル、項目名、商品名、金額表示など

---

## 原因の詳細

### 1. dompdfがデフォルトで日本語フォントを含んでいない

**技術的な背景:**
- dompdfはPDF生成ライブラリで、デフォルトで以下のフォントのみを含んでいます：
  - **英語フォント**: Helvetica、Times-Roman、Courier
  - **多言語フォント**: DejaVu Sans（一部の特殊文字に対応）
- 日本語文字（Unicode範囲: U+3040-U+309F, U+30A0-U+30FF, U+4E00-U+9FAFなど）のグリフ（文字形状）が含まれていません

**なぜ「？」が表示されるのか:**
- dompdfは日本語文字を認識できないため、代替文字として「？」を表示します
- これはフォントに該当するグリフが存在しない場合の標準的な動作です

### 2. フォントがdompdfに登録されていなかった

**問題点:**
- フォントファイル（.ttf）を`storage/fonts/`ディレクトリに配置しただけでは不十分
- dompdfは`installed-fonts.json`という設定ファイルを参照してフォントを認識します
- このファイルにフォント情報が登録されていないと、dompdfはフォントを使用できません

**`installed-fonts.json`の役割:**
```json
{
    "notosansjp": {
        "normal": "notosansjp",
        "bold": "notosansjp",
        "italic": "notosansjp",
        "bold_italic": "notosansjp"
    }
}
```
- フォントファミリー名と、実際のフォントファイル名のマッピングを定義
- dompdfがフォントを検索する際のインデックスとして機能

### 3. UFMファイルが生成されていなかった

**UFMファイルとは:**
- UFM（Unicode Font Metrics）ファイルは、フォントのメトリクス情報を含むファイルです
- 各文字の幅、高さ、ベースライン位置などの情報が含まれています

**なぜ必要か:**
- dompdfはPDFを生成する際、各文字の正確なサイズと位置を計算する必要があります
- TTFファイルだけでは、dompdfが直接メトリクスを読み取れないため、UFMファイルが必要です
- UFMファイルがないと、dompdfは文字の配置を正しく計算できません

**生成方法:**
- `php-font-lib`ライブラリを使用してTTFファイルからUFMファイルを生成します
- このライブラリはdompdfに含まれています

---

## 解決方法

### ステップ1: 日本語フォントファイルの準備

#### 推奨フォント
1. **Noto Sans JP**（今回使用）
   - Googleが提供するオープンソースフォント
   - 日本語を含む多言語に対応
   - ダウンロード: https://fonts.google.com/noto/specimen/Noto+Sans+JP
   - ライセンス: SIL Open Font License（商用利用可能）

2. **IPAフォント**
   - 情報処理推進機構が提供するフォント
   - 日本語に特化
   - ダウンロード: https://moji.or.jp/ipafont/
   - ライセンス: IPAフォントライセンス（商用利用可能）

#### フォントファイルの配置
```bash
# フォントファイルを storage/fonts/ ディレクトリに配置
storage/fonts/NotoSansJP-VariableFont_wght.ttf
```

### ステップ2: フォントの変換と登録

#### Artisanコマンドの実行
```bash
php artisan font:load-japanese
```

**このコマンドが実行する処理:**
1. TTFファイルを読み込み
2. `php-font-lib`を使用してUFMファイルを生成
3. フォントファイルを`notosansjp.ttf`としてコピー
4. `installed-fonts.json`にフォント情報を登録

**生成されるファイル:**
- `storage/fonts/notosansjp.ttf` - フォントファイル
- `storage/fonts/notosansjp.ufm` - UFMファイル
- `storage/fonts/installed-fonts.json` - フォント登録ファイル（更新）

### ステップ3: PDFテンプレートの修正

#### フォントファミリーの指定
`resources/views/quotations/pdf.blade.php`でフォントを指定：

```css
<style>
    @font-face {
        font-family: 'notosansjp';
        font-style: normal;
        font-weight: normal;
    }
    * {
        font-family: 'notosansjp', 'DejaVu Sans', sans-serif;
    }
    body {
        font-size: 12px;
    }
</style>
```

**フォールバックの設定:**
- 第1候補: `notosansjp`（日本語フォント）
- 第2候補: `DejaVu Sans`（英語・特殊文字用）
- 第3候補: `sans-serif`（システムデフォルト）

### ステップ4: コントローラーの設定

#### PDF生成時のオプション設定
`app/Http/Controllers/QuotationController.php`の`download`メソッド：

```php
public function download(Quotation $quotation)
{
    $this->authorize('view', $quotation);

    $quotation->load('items.product', 'user');

    $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))
        ->setOption('enable-font-subsetting', true)  // フォントサブセットを有効化
        ->setOption('isRemoteEnabled', true)         // リモートリソースを有効化
        ->setOption('fontDir', storage_path('fonts')) // フォントディレクトリを指定
        ->setOption('fontCache', storage_path('fonts')) // フォントキャッシュディレクトリを指定
        ->setPaper('a4', 'portrait');

    return $pdf->download('quotation-' . $quotation->quotation_number . '.pdf');
}
```

**各オプションの説明:**
- `enable-font-subsetting`: PDFに必要な文字のみを埋め込む（ファイルサイズ削減）
- `isRemoteEnabled`: リモートリソース（画像など）の読み込みを許可
- `fontDir`: フォントファイルの保存場所を指定
- `fontCache`: フォントキャッシュの保存場所を指定

### ステップ5: dompdf設定ファイルの確認

#### 設定ファイルの場所
`config/dompdf.php`

#### 重要な設定項目
```php
'options' => [
    'font_dir' => storage_path('fonts'),        // フォントディレクトリ
    'font_cache' => storage_path('fonts'),      // フォントキャッシュディレクトリ
    'enable_font_subsetting' => true,           // フォントサブセットを有効化
    'default_font' => 'DejaVu Sans',            // デフォルトフォント
    // ... その他の設定
],
```

---

## 設定ファイルの確認

### 1. installed-fonts.json

**場所:** `storage/fonts/installed-fonts.json`

**内容例:**
```json
{
    "notosansjp": {
        "normal": "notosansjp",
        "bold": "notosansjp",
        "italic": "notosansjp",
        "bold_italic": "notosansjp"
    }
}
```

**確認方法:**
```bash
cat storage/fonts/installed-fonts.json
```

### 2. フォントファイルの存在確認

**必要なファイル:**
- `storage/fonts/notosansjp.ttf` - フォントファイル
- `storage/fonts/notosansjp.ufm` - UFMファイル

**確認方法:**
```bash
ls -la storage/fonts/notosansjp.*
```

### 3. PDFテンプレートの確認

**ファイル:** `resources/views/quotations/pdf.blade.php`

**確認ポイント:**
- `@font-face`でフォントが定義されているか
- `font-family`で`notosansjp`が指定されているか

---

## トラブルシューティング

### 問題1: まだ文字化けが発生する

**確認事項:**
1. キャッシュをクリア
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

2. フォントファイルの存在確認
   ```bash
   ls -la storage/fonts/notosansjp.*
   ```

3. `installed-fonts.json`の内容確認
   ```bash
   cat storage/fonts/installed-fonts.json
   ```

4. ブラウザのキャッシュをクリアしてPDFを再ダウンロード

### 問題2: フォントコマンドが実行できない

**エラー: フォントファイルが見つかりません**
- `storage/fonts/`ディレクトリにフォントファイルが存在するか確認
- ファイル名が正しいか確認（デフォルト: `NotoSansJP-VariableFont_wght.ttf`）

**エラー: UFMファイルの生成に失敗**
- `php-font-lib`が正しくインストールされているか確認
- フォントファイルが破損していないか確認

### 問題3: PDFが生成されない

**確認事項:**
1. ストレージディレクトリの書き込み権限
   ```bash
   chmod -R 775 storage/
   ```

2. ログファイルの確認
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. PHPのメモリ制限
   - `php.ini`で`memory_limit`を確認（推奨: 256M以上）

### 問題4: フォントが正しく読み込まれない

**確認事項:**
1. `installed-fonts.json`のフォント名が正しいか
2. PDFテンプレートの`font-family`が正しいか
3. コントローラーで`fontDir`が正しく設定されているか

---

## 技術的な詳細

### dompdfのフォント読み込みプロセス

1. **フォントファミリーの検索**
   - CSSで指定された`font-family`を解析
   - `installed-fonts.json`から該当するフォントを検索

2. **フォントファイルの読み込み**
   - `fontDir`で指定されたディレクトリからTTFファイルを読み込み
   - UFMファイルからメトリクス情報を読み込み

3. **文字の描画**
   - 各文字のUnicodeコードポイントを取得
   - フォントから該当するグリフを検索
   - グリフが見つからない場合は「？」を表示

### フォントサブセットについて

**フォントサブセットとは:**
- PDFに使用されている文字のみを埋め込む技術
- ファイルサイズを大幅に削減できる
- 日本語フォントは通常10MB以上あるため、サブセット化が重要

**有効化方法:**
```php
->setOption('enable-font-subsetting', true)
```

---

## まとめ

### 解決に必要な作業の流れ

1. ✅ 日本語フォントファイルを`storage/fonts/`に配置
2. ✅ `php artisan font:load-japanese`でフォントを変換・登録
3. ✅ PDFテンプレートでフォントを指定
4. ✅ コントローラーでフォントディレクトリを指定
5. ✅ キャッシュをクリアしてPDFを再生成

### 重要なポイント

- **フォントファイルだけでは不十分**: UFMファイルと`installed-fonts.json`への登録が必要
- **フォントサブセットを有効化**: PDFファイルサイズを削減
- **フォールバックフォントを設定**: 日本語フォントが読み込めない場合の対策

### 今後のメンテナンス

- 新しい日本語フォントを追加する場合は、`php artisan font:load-japanese`コマンドを使用
- フォントファイルを更新する場合は、キャッシュをクリアすることを忘れずに
- `installed-fonts.json`は手動で編集しない（コマンドで自動生成される）

---

## 参考資料

- [dompdf公式ドキュメント](https://github.com/dompdf/dompdf)
- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)
- [Noto Sans JP](https://fonts.google.com/noto/specimen/Noto+Sans+JP)
- [IPAフォント](https://moji.or.jp/ipafont/)

---

**最終更新日:** 2024年12月11日  
**対応バージョン:** Laravel 12, dompdf 3.1



