@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <h2 class="auth-title">ログイン</h2>

    @if (session('status'))
    <div class="flash-message">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-row">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" >
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" >
            @error('password')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <button type="submit">ログイン</button>
        </div>

        <div class="form-footer">
            <a href="{{ route('register') }}">新規登録はこちら</a>
        </div>
    </form>
</div>
@endsection