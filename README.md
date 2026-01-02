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
4. **重要**: Railwayのダッシュボードで環境変数を設定：
   - `NIXPACKS_PHP_VERSION`: `8.2` （**必須** - NixpacksがPHPバージョンを検出するために必要）
   - `NIXPACKS_NODE_VERSION`: `18` （推奨 - Viteを使用している場合）
   - `APP_KEY`: `php artisan key:generate --show`で生成したキーを設定
   - `APP_ENV`: `production`
   - `APP_DEBUG`: `false`
   - `APP_URL`: Railwayが自動生成するURLを**HTTPS**で設定（例: `https://web-production-xxxxx.up.railway.app`）
   - `DB_CONNECTION`: `pgsql`
   - `USE_BOOTSTRAP_CDN`: `true` （オプション - CDNからBootstrapを読み込む場合。デフォルトは`false`でローカル版を使用）
   
   **PostgreSQL接続情報の設定**:
   - PostgreSQLサービスを追加した後、RailwayのダッシュボードでPostgreSQLサービスの「Variables」タブを確認
   - 以下の環境変数をLaravelサービスに追加（PostgreSQLサービスの環境変数を参照）:
     - `DB_HOST`: `${{Postgres.PGHOST}}` または PostgreSQLサービスの`PGHOST`の値
     - `DB_PORT`: `${{Postgres.PGPORT}}` または PostgreSQLサービスの`PGPORT`の値
     - `DB_DATABASE`: `${{Postgres.PGDATABASE}}` または PostgreSQLサービスの`PGDATABASE`の値
     - `DB_USERNAME`: `${{Postgres.PGUSER}}` または PostgreSQLサービスの`PGUSER`の値
     - `DB_PASSWORD`: `${{Postgres.PGPASSWORD}}` または PostgreSQLサービスの`PGPASSWORD`の値

**⚠️ 注意**: `NIXPACKS_PHP_VERSION`は大文字・アンダースコア含め完全一致が必要です。`PHP_VERSION`では動作しません。

6. **初回デプロイ後のセットアップ**（**手動実行が必要**）:
   
   デプロイが完了したら、以下のいずれかの方法でコマンドを実行：
   
   **方法1: Railway CLIを使用（推奨）**
   ```bash
   # Railway CLIをインストール（未インストールの場合）
   npm install -g @railway/cli
   
   # Railwayにログイン
   railway login
   
   # プロジェクトにリンク
   railway link
   
   # WEBサービス（Laravelアプリケーション）を選択してコマンドを実行
   railway run --service <WEB_SERVICE_NAME> php artisan migrate --force
   railway run --service <WEB_SERVICE_NAME> php artisan storage:link
   railway run --service <WEB_SERVICE_NAME> php artisan db:seed --class=AdminUserSeeder
   ```
   
   **⚠️ 重要**: `--service`オプションで**WEBサービス（Laravelアプリケーション）**を指定してください。PostgreSQLサービスではありません。
   
   **方法2: Railwayダッシュボードから実行**
   - Railwayのダッシュボードでサービスの「Settings」→「Deploy」セクションを確認
   - 「Run Command」または「Execute Command」などのオプションがある場合は、そこから実行
   - または、「View Logs」から一時的にコマンドを実行できる場合があります
   
   **実行するコマンド**:
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan db:seed --class=AdminUserSeeder
   ```
   
   **注意**: 
   - これらのコマンドは**初回デプロイ後のみ**実行してください
   - `AdminUserSeeder`は`firstOrCreate`を使用しているため、既にアカウントが存在する場合は新規作成されません

   **管理者アカウント情報**（シーダー実行後）:
   - Email: `admin@souwa.com`
   - Password: `password`
   - ⚠️ **重要**: 本番環境では、ログイン後すぐにパスワードを変更してください

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

**注意**: 
- `NIXPACKS_PHP_VERSION=8.2`を環境変数として設定しないと、`secret PHP not found`エラーが発生します（**必須**）
- composer.lockがPHP 8.4のパッケージにロックされている場合、PHP 8.2では動作しません
- その場合は、composer.lockを削除して、RailwayのPHP 8.2環境で再生成されます（初回ビルドに時間がかかる場合があります）
- 環境変数を設定した後、必ずRedeployを実行してください
- ログに「Installing PHP 8.2」が表示されれば、PHPバージョンの設定は正しく行われています

## 技術スタック

- **フレームワーク**: Laravel 12
- **PDF生成**: DomPDF (barryvdh/laravel-dompdf)
- **フロントエンド**: Bootstrap 5（ローカル版 / CDN版の切り替え可能）
- **データベース**: SQLite（デフォルト） / PostgreSQL（本番環境推奨）

### Bootstrapの使用方法

このプロジェクトでは、Bootstrapをローカル版とCDN版の両方に対応しています：

- **デフォルト（開発環境）**: ローカル版を使用（オフライン対応）
  - `npm install`でインストールされたBootstrapとBootstrap Iconsを使用
  - Viteでビルドして配信

- **本番環境（Railwayなど）**: 環境変数`USE_BOOTSTRAP_CDN=true`を設定するとCDN版を使用
  - CDNからBootstrapを読み込むため、ビルド時間が短縮されます
  - インターネット接続が必要です

**環境変数の設定**:
- `.env`ファイルに`USE_BOOTSTRAP_CDN=true`を追加するとCDN版を使用
- 設定しない、または`false`の場合はローカル版を使用

## ライセンス

このプロジェクトは個人利用・学習目的で作成されています。
