# プッシュ前チェックリスト

## ⚠️ 重要な確認事項

### 1. ブランチの確認
- [x] 現在のブランチ: `responsive`（mainではない）
- [ ] mainにマージする前に、`responsive`ブランチで動作確認済みか？

### 2. Bootstrap関連の変更確認
- [x] `package.json`に`bootstrap`と`bootstrap-icons`が追加されている
- [x] `resources/js/app.js`にBootstrapのインポートが追加されている
- [x] `resources/css/app.scss`にBootstrapのインポートが追加されている
- [x] `resources/views/layouts/app.blade.php`で環境変数によるCDN/ローカル切り替えが実装されている
- [x] README.mdに使用方法が記載されている

### 3. ビルドの確認
- [x] `npm run build`が正常に完了している
- [x] `public/build/manifest.json`に`resources/css/app.scss`が登録されている
- [ ] 開発環境で`npm run dev`が正常に動作するか確認済みか？

### 4. 環境変数の確認
- [ ] `.env.example`に`USE_BOOTSTRAP_CDN`の説明を追加する必要があるか？
  - 現在はREADME.mdに記載されているが、`.env.example`にも追加推奨

### 5. その他の変更ファイルの確認
以下のファイルも変更されていますが、Bootstrap関連以外の変更の可能性があります：
- `resources/views/cart/index.blade.php`
- `resources/views/category/show.blade.php`
- `resources/views/home.blade.php`
- `resources/views/products/index.blade.php`
- `resources/views/products/show.blade.php`
- `resources/views/quotations/*.blade.php`
- `resources/views/news/create.blade.php`
- `vite.config.js`
- `.php-version`, `Procfile`, `PDF_JAPANESE_FONT_GUIDE.md`

**確認事項**: これらの変更が意図したものか確認してください。

### 6. 動作確認
- [ ] ローカル環境でアプリケーションが正常に動作するか？
- [ ] Bootstrapのスタイルが正しく適用されているか？
- [ ] Bootstrap Iconsが正しく表示されているか？
- [ ] モーダルやドロップダウンなどのBootstrapコンポーネントが動作するか？
- [ ] オフライン環境（CDN無効）で動作するか？

### 7. 本番環境（Railway）への影響
- [ ] Railwayで`USE_BOOTSTRAP_CDN=true`を設定するか、ローカル版を使用するか決定
- [ ] Railwayでのビルドプロセスが正常に動作するか確認（`npm run build`が実行されるか）
- [ ] 本番環境での動作確認が必要

### 8. Git関連
- [x] `.gitignore`に`/public/build`が含まれている（ビルドファイルはコミットされない）
- [ ] コミットメッセージが適切か？
- [ ] 不要なファイルがステージングされていないか？

## 推奨される手順

1. **ローカルで動作確認**
   ```bash
   npm run dev
   # ブラウザで動作確認
   ```

2. **ビルドの確認**
   ```bash
   npm run build
   # エラーがないか確認
   ```

3. **変更内容の確認**
   ```bash
   git diff
   # 意図しない変更がないか確認
   ```

4. **コミット**
   ```bash
   git add .
   git commit -m "feat: Bootstrapをローカル版とCDN版の両方に対応

   - Bootstrap 5.3.0とBootstrap Icons 1.11.0をnpmパッケージとして追加
   - 環境変数USE_BOOTSTRAP_CDNでCDN/ローカルを切り替え可能に
   - デフォルトはローカル版（オフライン対応）
   - READMEに使用方法を追記"
   ```

5. **responsiveブランチにプッシュ**
   ```bash
   git push origin responsive
   ```

6. **mainへのマージ前の最終確認**
   - プルリクエストを作成してレビュー
   - または、ローカルでmainにマージして動作確認

## 注意事項

- `app.scss`が大幅に増加しています（Bootstrapが含まれるため）
- Bootstrap Iconsのフォントパス設定が追加されています（`$bootstrap-icons-font-dir`）
- 他のビューファイルにも変更があるため、全体の動作確認が必要です

