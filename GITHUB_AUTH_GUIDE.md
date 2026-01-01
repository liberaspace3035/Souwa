# GitHub認証ガイド

## 方法1: GitHub CLIでブラウザ認証（推奨・最も簡単）

### 手順

1. ターミナルで以下のコマンドを実行:
```bash
gh auth login -h github.com -w
```

2. ブラウザが自動的に開きます
3. 画面に表示されたコード（例: `XXXX-XXXX`）をコピー
4. ブラウザでGitHubにログインし、コードを入力
5. 「Authorize github」をクリックして認証を完了

### 認証後のプッシュ

認証が完了したら、以下のコマンドでプッシュできます:
```bash
git push -u origin main
```

---

## 方法2: パーソナルアクセストークン（PAT）を使用

### 手順

1. GitHubにログイン: https://github.com
2. 右上のプロフィール画像をクリック → **Settings**
3. 左メニューから **Developer settings** を選択
4. **Personal access tokens** → **Tokens (classic)** を選択
5. **Generate new token** → **Generate new token (classic)** をクリック
6. 以下を設定:
   - **Note**: `Railway Deployment` など任意の名前
   - **Expiration**: 有効期限を選択（90日、1年、または無期限）
   - **Scopes**: 以下をチェック
     - ✅ `repo` (すべてのチェックボックス)
     - ✅ `workflow` (必要に応じて)
7. **Generate token** をクリック
8. 表示されたトークンを**すぐにコピー**（次回は表示されません）

### プッシュ時の使用

```bash
git push -u origin main
```
- **Username**: `liberaspace3035`
- **Password**: 先ほどコピーしたパーソナルアクセストークンを貼り付け

---

## 方法3: SSHキーを使用

### 手順

1. SSHキーの生成（まだ持っていない場合）:
```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
# Enterを3回押してデフォルト設定で作成
```

2. SSHキーをGitHubに追加:
```bash
# 公開鍵をクリップボードにコピー
cat ~/.ssh/id_ed25519.pub | pbcopy
```

3. GitHubにログイン: https://github.com
4. 右上のプロフィール画像 → **Settings**
5. 左メニューから **SSH and GPG keys** を選択
6. **New SSH key** をクリック
7. **Title**: 任意の名前（例: `MacBook Pro`）
8. **Key**: 先ほどコピーした公開鍵を貼り付け
9. **Add SSH key** をクリック

### リモートURLをSSHに変更

```bash
git remote set-url origin git@github.com:liberaspace3035/Souwa.git
```

### プッシュ

```bash
git push -u origin main
```

---

## 認証状態の確認

どの方法を使った場合でも、以下のコマンドで認証状態を確認できます:

```bash
# GitHub CLIの認証状態を確認
gh auth status

# Gitリモートの設定を確認
git remote -v
```

