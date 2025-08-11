# 「農作業日誌」

農作業の記録を日付・作業内容・天気・画像付きで管理できるWebアプリです。  
個人農家向けに、シンプルで直感的な操作性を重視しています。

## 実装済み機能一覧

- ユーザー認証（Fortify使用）
- 農作業の登録・編集・削除
- 作業日、天気、カテゴリ、キーワード検索
- 作業画像のアップロード・表示
- 年月やキーワードでのフィルタリング
- カレンダー表示機能
- CSVエクスポート
- ユーザーごとのデータ管理

## dockerビルド手順

1. リポジトリのクローン

    `git clone https://github.com:tomo1583gh/farm-work-diary.git`

2. 階層を変更
　　`cd farm-work-diary`

3. Dockerコンテナのビルド・起動

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

6. 初期データを投入

    `php artisan db:seed`

## 使用技術

- php 8.2.12

- laravel 8.83.29

- MySQL 8.0.26

- Fortify【認証機能】

- Mailhog【メール確認】

- Stripe【支払い処理】

- Blade + CSS

- Docker

## URL

- 開発環境：http://localhost:8000

- phpMyAdmin:http://localhost:8080

- Mailhog:http://localhost:8025

- Stripe:https://dashboard.stripe.com/test

## テストユーザーについて

アプリ起動後、Seederにより自動でテストユーザーが作成されます  
ログインや購入機能の動作確認にご利用ください

### ログイン情報（ダミーユーザー）

メールアドレス：test@example.com  
パスワード：password