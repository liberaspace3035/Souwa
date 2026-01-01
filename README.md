# SOUWA - 精選最優質日本食材 ECサイト

Laravelで構築されたECサイト風の見積書生成システムです。

## 機能

- **認証・会員機能**: ユーザー登録、ログイン、会員権限管理（管理者/一般ユーザー）
- **商品管理**: 商品の登録・編集・削除・一覧表示（管理者のみ）
- **カート機能**: カートへの商品追加、削除、数量変更
- **PDF見積書生成**: Bladeテンプレートを使用した見積書作成、DomPDFでのPDF出力・ダウンロード機能
- **レスポンシブ対応**: PC・スマホ・タブレット対応

## セットアップ

### 必要な環境

- PHP 8.2以上
- Composer
- SQLite（デフォルト）またはMySQL/PostgreSQL

### インストール手順

1. 依存関係のインストール
```bash
composer install
```

2. 環境変数の設定
```bash
cp .env.example .env
php artisan key:generate
```

3. データベースのマイグレーション
```bash
php artisan migrate
```

4. ストレージリンクの作成
```bash
php artisan storage:link
```

5. 開発サーバーの起動
```bash
php artisan serve
```

## 管理者アカウントの作成

データベースに直接管理者アカウントを作成するか、以下のコマンドで作成できます：

```bash
php artisan tinker
```

```php
$user = \App\Models\User::create([
    'name' => '管理者',
    'email' => 'admin@example.com',
    'password' => \Hash::make('password'),
    'role' => 'admin',
]);
```

## 使用方法

### 一般ユーザー

1. 新規登録またはログイン
2. 商品一覧から商品を閲覧
3. 商品詳細ページからカートに追加
4. カートページで数量を調整
5. 見積書を作成
6. PDF見積書をダウンロード

### 管理者

1. 管理者アカウントでログイン
2. ナビゲーションメニューから「商品管理」を選択
3. 商品の登録・編集・削除が可能

## Railwayへのデプロイ

Railwayでこのアプリケーションをデプロイする手順：

1. Railwayアカウントを作成し、新しいプロジェクトを作成
2. GitHubリポジトリを接続（またはGitリポジトリを追加）
3. PostgreSQLサービスを追加（データベース用）
4. 環境変数を設定：
   - `APP_KEY`: `php artisan key:generate --show`で生成したキーを設定
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_URL`: Railwayが自動生成するURLを設定
   - `DB_CONNECTION`: `pgsql`
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: PostgreSQLサービスの接続情報を設定（Railwayが自動設定）
6. デプロイ後、Railwayのコンソール（「Deployments」→「View Logs」→「Shell」タブ）で以下のコマンドを実行：
   ```bash
   php artisan migrate --force
   php artisan storage:link
   ```

### 500エラーのトラブルシューティング

500エラーが発生する場合、以下を確認してください：

1. **APP_KEYが設定されているか確認**:
   - Railwayのダッシュボードで「Variables」タブを確認
   - `APP_KEY`が設定されているか確認
   - 設定されていない場合は、ローカルで以下を実行してキーを生成：
     ```bash
     php artisan key:generate --show
     ```
   - 生成されたキーをRailwayの環境変数`APP_KEY`に設定

2. **データベース接続を確認**:
   - PostgreSQLサービスが正しく接続されているか確認
   - 環境変数`DB_CONNECTION=pgsql`が設定されているか確認
   - PostgreSQLサービスの接続情報（`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`）が自動設定されているか確認

3. **マイグレーションを実行**:
   ```bash
   php artisan migrate --force
   ```

4. **ストレージリンクを作成**:
   ```bash
   php artisan storage:link
   ```

5. **ログを確認**:
   - Railwayの「Deployments」→「View Logs」でエラーログを確認
   - `APP_DEBUG=true`に設定して（一時的に）、詳細なエラー情報を確認

6. **キャッシュをクリア**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

**注意**: RailwayはPHP 8.2（デフォルト）を使用します。composer.lockがリポジトリに含まれていない場合、Railwayのビルド時に自動的に生成されます。

## 技術スタック

- **フレームワーク**: Laravel 12
- **PDF生成**: DomPDF (barryvdh/laravel-dompdf)
- **フロントエンド**: Bootstrap 5
- **データベース**: SQLite（デフォルト） / PostgreSQL（本番環境推奨）

## ライセンス

このプロジェクトは個人利用・学習目的で作成されています。
