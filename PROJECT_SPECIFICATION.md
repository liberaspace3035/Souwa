# SOUWA - プロジェクト仕様書

## 📋 プロジェクト概要

**プロジェクト名**: SOUWA（送和）- 厳選最高品質日本食材 卸売直送サイト  
**プロジェクトタイプ**: 決済機能のないECサイト風の見積書生成システム  
**フレームワーク**: Laravel 12.10.1  
**開発言語**: PHP 8.2+  
**データベース**: SQLite（デフォルト）/ MySQL / PostgreSQL対応

---

## 🎯 実装済み機能一覧

### ✅ 1. 認証・会員機能（完成度: 100%）

#### 実装内容
- **ユーザー登録機能**
  - 新規ユーザー登録フォーム
  - バリデーション（名前、メールアドレス、パスワード8文字以上、確認用パスワード）
  - 自動ログイン機能
  - パスワードハッシュ化（Laravel標準）

- **ログイン機能**
  - メールアドレス・パスワード認証
  - 「ログイン状態を保持する」機能（Remember Me）
  - セッション管理
  - ログイン失敗時のエラーメッセージ表示

- **ログアウト機能**
  - セッション無効化
  - CSRFトークン再生成

- **会員権限管理**
  - ロールベースアクセス制御（RBAC）
  - ユーザーロール: `user`（一般ユーザー）、`admin`（管理者）
  - 管理者専用機能へのアクセス制限

#### 技術実装
- `RegisterController`: ユーザー登録処理
- `LoginController`: ログイン・ログアウト処理
- `AdminMiddleware`: 管理者権限チェック
- `User`モデル: `isAdmin()`メソッドで権限判定

---

### ✅ 2. 商品管理機能（完成度: 100%）

#### 一般ユーザー向け機能
- **商品一覧表示** (`/products`)
  - 商品カード形式での表示
  - カテゴリーフィルター機能（8カテゴリー）
  - 商品名検索機能
  - ページネーション（12件/ページ）
  - 商品画像表示（プレースホルダー対応）

- **商品詳細表示** (`/products/{id}`)
  - 商品画像、名前、カテゴリー、価格、説明の表示
  - 在庫状況表示
  - カート追加機能（ログイン時のみ）
  - 数量選択機能（在庫数まで）

#### 管理者向け機能（独自CMS）
- **商品一覧管理** (`/admin/products`)
  - 全商品の一覧表示（20件/ページ）
  - 商品ID、名前、カテゴリー、価格、在庫の表示
  - サムネイル画像表示
  - 編集・削除ボタン

- **商品登録** (`/admin/products/create`)
  - 商品名（必須）
  - 商品説明（任意）
  - 価格（必須、数値）
  - 商品画像アップロード（任意、最大2MB）
  - カテゴリー選択（8種類）
  - 在庫数設定
  - フラグ設定（おすすめ商品、期間限定、新商品）

- **商品編集** (`/admin/products/{id}/edit`)
  - 登録時と同様のフォーム
  - 既存データの自動入力
  - 画像差し替え機能（既存画像削除対応）

- **商品削除**
  - 確認ダイアログ表示
  - 関連画像ファイルの自動削除
  - カスケード削除（カートアイテムも削除）

#### データベース構造
```sql
products テーブル:
- id (主キー)
- name (商品名)
- description (説明)
- price (価格: decimal 10,2)
- image (画像パス)
- category (カテゴリー)
- stock (在庫数)
- is_featured (おすすめフラグ)
- is_limited (期間限定フラグ)
- is_new (新商品フラグ)
- created_at, updated_at
```

---

### ✅ 3. カート機能（完成度: 100%）

#### 実装内容
- **カート表示** (`/cart`)
  - ログイン必須
  - カート内商品一覧表示
  - 商品画像、名前、単価、数量、小計の表示
  - 数量変更機能
  - 商品削除機能
  - 小計・消費税（10%）・合計金額の自動計算
  - カートが空の場合のメッセージ表示

- **カート追加** (`/cart/add/{product}`)
  - 商品詳細ページから追加
  - 数量指定（1以上、在庫数まで）
  - 既存商品の場合は数量を加算
  - 新規商品の場合は新規レコード作成

- **数量変更** (`/cart/{cartItem}`)
  - PUTリクエストで数量更新
  - 権限チェック（自分のカートのみ編集可能）

- **カート削除** (`/cart/{cartItem}`)
  - DELETEリクエストで削除
  - 権限チェック（自分のカートのみ削除可能）

#### セキュリティ
- `CartItemPolicy`: ユーザーは自分のカートアイテムのみ操作可能
- 認証必須（`auth`ミドルウェア）

#### データベース構造
```sql
cart_items テーブル:
- id (主キー)
- user_id (外部キー: users.id)
- product_id (外部キー: products.id)
- quantity (数量)
- created_at, updated_at
```

---

### ✅ 4. PDF見積書生成機能（完成度: 100%）

#### 実装内容
- **見積書作成** (`/quotations/create`)
  - カート内容を基に見積書作成
  - 有効期限設定（任意）
  - 備考欄（任意）
  - 見積書作成後、カートを自動クリア

- **見積書一覧** (`/quotations`)
  - ログインユーザーの見積書一覧表示
  - 見積書番号、作成日、合計金額の表示
  - ページネーション（10件/ページ）

- **見積書詳細** (`/quotations/{id}`)
  - 見積書番号、作成日、有効期限の表示
  - 商品明細一覧（商品名、数量、単価、小計）
  - 小計・消費税・合計金額の表示
  - 備考欄表示
  - PDFダウンロードボタン

- **PDFダウンロード** (`/quotations/{id}/download`)
  - DomPDFを使用したPDF生成
  - Bladeテンプレートでレイアウト
  - 見積書番号をファイル名に使用
  - ブラウザで直接ダウンロード

#### 見積書番号生成ルール
- 形式: `Q + YYYYMMDDHHmmss + ユーザーID`
- 例: `Q202512081507301`

#### データベース構造
```sql
quotations テーブル:
- id (主キー)
- user_id (外部キー: users.id)
- quotation_number (見積書番号、ユニーク)
- quotation_date (見積書日付)
- valid_until (有効期限、任意)
- subtotal (小計)
- tax (消費税)
- total (合計)
- notes (備考、任意)
- created_at, updated_at

quotation_items テーブル:
- id (主キー)
- quotation_id (外部キー: quotations.id)
- product_id (外部キー: products.id、nullable)
- product_name (商品名、スナップショット)
- quantity (数量)
- price (単価)
- subtotal (小計)
- created_at, updated_at
```

#### セキュリティ
- `QuotationPolicy`: ユーザーは自分の見積書のみ閲覧可能
- 認証必須

---

### ✅ 5. NEWS管理機能（完成度: 100%）

#### 一般ユーザー向け機能
- **NEWS一覧** (`/news`)
  - 公開済みNEWSの一覧表示
  - カード形式での表示
  - 画像、タイトル、公開日、内容の表示
  - リンクURLがある場合は外部リンク
  - ページネーション（10件/ページ）

- **NEWS詳細** (`/news/{id}`)
  - 画像、タイトル、公開日、内容の表示
  - リンクURLがある場合は外部リンクボタン

- **ホームページ連携**
  - 最新の公開済みNEWSを自動表示
  - 画像・タイトル・リンクに対応

#### 管理者向け機能（独自CMS）
- **NEWS一覧管理** (`/admin/news`)
  - 全NEWSの一覧表示（20件/ページ）
  - タイトル、画像、公開日、公開状態の表示
  - 編集・削除ボタン

- **NEWS登録** (`/admin/news/create`)
  - タイトル（必須）
  - 内容（任意）
  - 画像アップロード（任意、最大2MB）
  - リンクURL（任意）
  - 公開日設定（任意）
  - 公開状態チェックボックス

- **NEWS編集** (`/admin/news/{id}/edit`)
  - 登録時と同様のフォーム
  - 既存データの自動入力
  - 画像差し替え機能

- **NEWS削除**
  - 確認ダイアログ表示
  - 関連画像ファイルの自動削除

#### データベース構造
```sql
news テーブル:
- id (主キー)
- title (タイトル)
- content (内容)
- image (画像パス)
- link (リンクURL)
- published_at (公開日)
- is_published (公開フラグ)
- created_at, updated_at
```

---

### ✅ 6. フロントページ制作（完成度: 95%）

#### 実装済みセクション
1. **告知バナー**
   - 背景色: #D4A574（オレンジ/ベージュ）
   - テキスト: 日本語
   - レスポンシブ対応

2. **メインプロモーションバナー**
   - 赤のグラデーション背景
   - 中央配置テキスト
   - レスポンシブ対応

3. **NEWSセクション**
   - 左側: NEWSボックス（#D4A574背景）
   - 右側: 画像表示エリア
   - 最新NEWSの動的表示

4. **生産者の声セクション**
   - タイトル: "\ 生產商們的聲音 / Voices of the Producers"
   - アクションエリア: Check / ボタン / More! / 矢印ナビゲーション
   - ライトグレー背景

5. **商品/生産者選択セクション**
   - 2つのタブ（空港選択 / 生産者選択）
   - 空港ボタン（6つ）
   - アクティブ状態の視覚的フィードバック

6. **商品セクション**
   - NEW ITEMS（新商品）
   - PERIOD LIMITED ITEMS（期間限定商品）
   - BEST SELLING ITEMS（人気商品）
   - 各セクションに縦線アクセント、SOUWAロゴ、CTAボタン

7. **空港カードセクション**
   - 6つの空港カード（2列3行）
   - 縦書きテキスト
   - ダークグレー背景、白いボーダー
   - ホバーエフェクト

8. **特徴セクション**
   - 3つの特徴カード
   - アイコン、タイトル、説明文

#### デザイン仕様
- **カラーパレット**:
  - プライマリ: #2C2C2C（ダークチャコール）
  - セカンダリ: #706f6c（グレー）
  - アクセント: #F53003（レッド）
  - ウォームオレンジ: #D4A574
  - 背景: #FDFDFC（オフホワイト）

- **フォント**:
  - 日本語: 'Hiragino Kaku Gothic ProN', 'Hiragino Sans', Meiryo
  - 英語: システムフォント

- **レスポンシブ対応**:
  - PC（デスクトップ）
  - タブレット（768px以上）
  - スマートフォン（576px以下）

#### ヘッダー
- ロゴ: "送和 SOUWA" + 小麦アイコン
- トップリンク: 日本直送について | フォローする + SNSアイコン
- アクションボタン: ログイン・登録 / カート / SOUWAについて
- 選択バー: 発送空港選択 / 食材種類選択（ドロップダウンメニュー）

#### フッター
- 背景色: #D4A574
- ロゴ: "送和 SOUWA"
- ナビゲーションリンク: ショッピングの流れ / よくある質問 / お問い合わせ / フォローする
- SNSアイコン + QRコード（友達とシェア）
- コピーライト

---

### ✅ 7. レスポンシブ対応（完成度: 95%）

#### 実装内容
- Bootstrap 5を使用したグリッドシステム
- メディアクエリによる調整
- モバイル向けのナビゲーション調整
- フォントサイズの自動調整
- 画像のレスポンシブ対応

#### 対応デバイス
- **デスクトップ**: 992px以上
- **タブレット**: 768px - 991px
- **スマートフォン**: 576px以下

---

## 🔒 セキュリティ機能

### 実装済み
1. **認証・認可**
   - Laravel標準認証システム
   - パスワードハッシュ化（bcrypt）
   - CSRF保護
   - セッション管理

2. **権限管理**
   - ロールベースアクセス制御（RBAC）
   - `AdminMiddleware`による管理者権限チェック
   - Policyによるリソース単位の権限管理

3. **データ保護**
   - 入力バリデーション
   - SQLインジェクション対策（Eloquent ORM）
   - XSS対策（Bladeエスケープ）
   - ファイルアップロード制限（画像のみ、最大2MB）

4. **アクセス制御**
   - `CartItemPolicy`: 自分のカートのみ操作可能
   - `QuotationPolicy`: 自分の見積書のみ閲覧可能
   - 管理者専用ルートの保護

---

## 📊 データベース構造

### テーブル一覧

1. **users**（ユーザー）
   - id, name, email, password, role, email_verified_at, remember_token, created_at, updated_at

2. **products**（商品）
   - id, name, description, price, image, category, stock, is_featured, is_limited, is_new, created_at, updated_at

3. **cart_items**（カートアイテム）
   - id, user_id, product_id, quantity, created_at, updated_at

4. **quotations**（見積書）
   - id, user_id, quotation_number, quotation_date, valid_until, subtotal, tax, total, notes, created_at, updated_at

5. **quotation_items**（見積書明細）
   - id, quotation_id, product_id, product_name, quantity, price, subtotal, created_at, updated_at

6. **news**（ニュース）
   - id, title, content, image, link, published_at, is_published, created_at, updated_at

### リレーション
- User → CartItem (1対多)
- User → Quotation (1対多)
- Product → CartItem (1対多)
- Product → QuotationItem (1対多、nullable)
- Quotation → QuotationItem (1対多)
- CartItem → Product (多対1)
- CartItem → User (多対1)
- Quotation → User (多対1)
- QuotationItem → Quotation (多対1)
- QuotationItem → Product (多対1、nullable)

---

## 🛠 技術スタック

### バックエンド
- **フレームワーク**: Laravel 12.10.1
- **PHP**: 8.2以上
- **データベース**: SQLite（デフォルト）/ MySQL / PostgreSQL対応
- **PDF生成**: DomPDF (barryvdh/laravel-dompdf) 3.1

### フロントエンド
- **CSSフレームワーク**: Bootstrap 5.3.0
- **アイコン**: Bootstrap Icons 1.11.0
- **テンプレートエンジン**: Blade
- **JavaScript**: バニラJS（Bootstrap依存）

### 開発ツール
- **パッケージ管理**: Composer
- **テスト**: PHPUnit 11.5.3
- **コードスタイル**: Laravel Pint 1.24

---

## 📁 プロジェクト構造

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   └── RegisterController.php
│   │   ├── CartController.php
│   │   ├── HomeController.php
│   │   ├── NewsController.php
│   │   ├── ProductController.php
│   │   └── QuotationController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── CartItem.php
│   ├── News.php
│   ├── Product.php
│   ├── Quotation.php
│   ├── QuotationItem.php
│   └── User.php
└── Policies/
    ├── CartItemPolicy.php
    └── QuotationPolicy.php

database/
└── migrations/
    ├── 2025_12_08_134326_create_products_table.php
    ├── 2025_12_08_134326_create_cart_items_table.php
    ├── 2025_12_08_134326_create_quotations_table.php
    ├── 2025_12_08_134326_create_quotation_items_table.php
    ├── 2025_12_08_134403_add_role_to_users_table.php
    └── 2025_12_08_150735_create_news_table.php

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php（メインレイアウト）
    ├── auth/
    │   ├── login.blade.php
    │   └── register.blade.php
    ├── products/
    │   ├── index.blade.php（一般ユーザー向け）
    │   ├── show.blade.php
    │   ├── admin_index.blade.php（管理者向け）
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── news/
    │   ├── index.blade.php（一般ユーザー向け）
    │   ├── show.blade.php
    │   ├── admin_index.blade.php（管理者向け）
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── cart/
    │   └── index.blade.php
    ├── quotations/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── show.blade.php
    │   └── pdf.blade.php（PDFテンプレート）
    └── home.blade.php（トップページ）
```

---

## 📈 達成度・完成度

### 要件別達成度

| 機能 | 要件 | 達成度 | 備考 |
|------|------|--------|------|
| **認証・会員機能** | ユーザー登録、ログイン、会員権限管理 | **100%** | 完全実装済み |
| **商品管理（Laravel側）** | 商品登録・編集・削除・一覧表示 | **100%** | 独自CMS実装済み |
| **カート機能** | カート追加、削除、数量変更、表示 | **100%** | 完全実装済み |
| **PDF見積書生成** | Bladeテンプレート、DomPDF出力・ダウンロード | **100%** | 完全実装済み |
| **フロントページ制作** | トップページ、商品一覧・詳細、カート、マイページ | **95%** | デザイン調整中 |
| **レスポンシブ対応** | PC・スマホ・タブレット対応 | **95%** | 細かい調整が必要な可能性あり |
| **NEWS管理機能** | NEWS登録・編集・削除・表示 | **100%** | 独自CMS実装済み（追加実装） |

### 全体達成度: **98%**

---

## 🎨 デザイン実装状況

### 完成済み
- ✅ ヘッダーデザイン（ロゴ、ナビゲーション、アクションボタン）
- ✅ フッターデザイン（ロゴ、ナビゲーション、SNS、QRコード）
- ✅ ヘッダー選択バー（空港選択、食材種類選択）
- ✅ 告知バナー
- ✅ プロモーションバナー
- ✅ NEWSセクション
- ✅ 生産者の声セクション
- ✅ 商品/生産者選択セクション
- ✅ 商品セクション（NEW ITEMS、期間限定、人気商品）
- ✅ 空港カードセクション

### 調整中・未完成
- ⚠️ 細かいカラー調整（画像との完全一致）
- ⚠️ フォントサイズの微調整
- ⚠️ スペーシングの最終調整

---

## 🔧 管理機能（独自CMS）

### 商品管理CMS
- **URL**: `/admin/products`
- **機能**: CRUD操作すべて実装済み
- **アクセス**: 管理者のみ

### NEWS管理CMS
- **URL**: `/admin/news`
- **機能**: CRUD操作すべて実装済み
- **アクセス**: 管理者のみ

### 管理画面の特徴
- 直感的なUI（Bootstrap 5ベース）
- 画像アップロード機能
- バリデーション機能
- エラーメッセージ表示
- 成功メッセージ表示
- 確認ダイアログ（削除時）

---

## 📝 使用可能な機能一覧

### 一般ユーザー
1. ユーザー登録
2. ログイン・ログアウト
3. 商品一覧閲覧（検索・フィルター機能付き）
4. 商品詳細閲覧
5. カートへの商品追加
6. カート内商品の数量変更
7. カート内商品の削除
8. 見積書作成
9. 見積書一覧閲覧
10. 見積書詳細閲覧
11. PDF見積書ダウンロード
12. NEWS一覧閲覧
13. NEWS詳細閲覧

### 管理者
1. 上記すべての一般ユーザー機能
2. 商品管理（一覧・登録・編集・削除）
3. NEWS管理（一覧・登録・編集・削除）
4. 管理者専用ナビゲーションメニュー

---

## 🚀 デプロイ準備状況

### 完了項目
- ✅ データベースマイグレーション準備済み
- ✅ ストレージリンク設定（画像アップロード対応）
- ✅ 環境変数設定（.env）
- ✅ ルーティング設定完了
- ✅ ミドルウェア設定完了
- ✅ ポリシー設定完了

### 必要な設定
- 本番環境の`.env`設定
- ストレージディレクトリの権限設定
- 管理者アカウントの作成

---

## 📌 今後の拡張可能性

### 追加可能な機能
1. **メール通知機能**
   - 見積書作成時のメール送信
   - パスワードリセット機能

2. **在庫管理機能の強化**
   - 在庫アラート
   - 入荷通知

3. **検索機能の強化**
   - 全文検索
   - 高度なフィルター

4. **レポート機能**
   - 売上レポート
   - 商品別レポート

5. **API機能**
   - RESTful API
   - 外部システム連携

---

## 📞 サポート情報

### 管理者アカウント作成方法
```bash
php artisan tinker
```
```php
\App\Models\User::create([
    'name' => '管理者',
    'email' => 'admin@example.com',
    'password' => \Hash::make('password'),
    'role' => 'admin',
]);
```

### デフォルト管理者アカウント（Seeder）
- Email: `admin@souwa.com`
- Password: `password`
- Role: `admin`

---

## ✅ 品質保証

### 実装済み
- ✅ 入力バリデーション
- ✅ エラーハンドリング
- ✅ セキュリティ対策
- ✅ レスポンシブデザイン
- ✅ アクセシビリティ（基本的な対応）

### テスト推奨項目
- [ ] ユーザー登録・ログインの動作確認
- [ ] 商品管理のCRUD操作確認
- [ ] カート機能の動作確認
- [ ] 見積書生成・PDFダウンロード確認
- [ ] NEWS管理のCRUD操作確認
- [ ] レスポンシブデザインの確認
- [ ] 権限管理の動作確認

---

**最終更新日**: 2025年12月8日  
**プロジェクト状態**: 開発完了（細かい調整可能）

