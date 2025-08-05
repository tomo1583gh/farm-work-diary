# 「農作業日誌」

個人農家向けに開発した、作業記録の管理ができるWebアプリケーションです。  
作業内容をカレンダーで可視化し、CSV出力も可能です。

## 実装済み機能一覧

- ✅ ログイン / 会員登録（Fortify使用）
- ✅ 作業内容の登録・編集・削除
- ✅ 作業一覧（キーワード検索、日付絞り込み、ページネーション）
- ✅ カレンダー表示（FullCalendar）
- ✅ CSVエクスポート
- ✅ 画像アップロード（作業ごとの写真）


## dockerビルド手順

1. リポジトリのクローン

    `git clone git@github.com:tomo1583gh/farm-work-diary.git`

2. Dockerコンテナのビルド・起動

    `docker-compose up -d --build`

    ※  MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集して下さい。

## laravel　環境構築

1. PHPコンテナに入る

    `docker-compose exec php bash`

2. Composerで依存パッケージをインストール

    `composer install`

3. .envファイルを作成

    `cp .env.example .env`

    必要に応じて環境変数を編集

4. アプリケーションキーを生成

    `php artisan key:generate`

5. マイグレーションを実行

    `php artisan migrate`

6. サンプルデータを投入（任意

    `php artisan db:seed`

7. シンボリックリンクの作成（画像表示用）

    `php artisan storage:link`

8.  アプリ起動

    `php artisan serve`

## 使用技術

- php 8.2.12

- laravel 8.83.29

- MySQL 8.0.26

- Fortify【認証機能】

- Blade + CSS

## URL

- 開発環境：http://localhost:8000

- phpMyAdmin:http://localhost:8080

## テストユーザーについて

アプリ起動後、Seederにより自動でテストユーザーが作成されます  
ログインや購入機能の動作確認にご利用ください

### ログイン情報（ダミーユーザー）

メールアドレス：test@example.com  
パスワード：password