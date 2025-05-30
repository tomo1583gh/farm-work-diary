@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <h2 class="auth-title">新規登録</h2>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-row">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}">
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password">
            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password_confirmation">パスワード（確認）</label>
            <input id="password_confirmation" type="password" name="password_confirmation">
        </div>

        <div class="form-row">
            <button type="submit">登録する</button>
        </div>

        <div class="form-footer">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection