@extends('layouts.app')

@section('content')
<h2>作業の新規登録</h2>

<form action="{{ route('works.store') }}" method="POST" enctype="multipart/form-data" class="work-form">
    @csrf
    <div>
        <label>作業日:</label> <!-- 日本語 -->
        <input type="date" name="work_date" value="{{ old('work_date', $work->work_date ?? '') }}">
        @error('work_date') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>天気:</label>
        <select name="weather">
            <option value="">選択してください</option>
            <option value="晴れ" {{ old('weather') == '晴れ' ? 'selected' : '' }}>晴れ</option>
            <option value="曇り" {{ old('weather') == '曇り' ? 'selected' : '' }}>曇り</option>
            <option value="雨" {{ old('weather') == '雨' ? 'selected' : '' }}>雨</option>
            <option value="雪" {{ old('weather') == '雪' ? 'selected' : '' }}>雪</option>
        </select>
        @error('weather') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>タイトル:</label> <!-- 日本語 -->
        <input type="text" name="title" value="{{ old('title', $work->title ?? '') }}">
        @error('title') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>カテゴリ:</label> <!-- 日本語 -->
        <input type="text" name="category_name" value="{{ old('category_name', $work->category_name ?? '') }}">
        @error('category_name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>作業時間（分）:</label> <!-- 日本語 -->
        <input type="number" name="work_time" value="{{ old('work_time', $work->work_time ?? '') }}">
        @error('work_time') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>作業写真：</label>
        <input type="file" name="image">
        @error('image') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>内容:</label> <!-- 日本語 -->
        <textarea name="content">{{ old('content', $work->content ?? '') }}</textarea>
        @error('content') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="button-area">
        <button type="submit" class="btn">登録</button>
        <a href="{{ route('works.index') }}" class="btn">一覧に戻る</a>
    </div>

</form>
@endsection