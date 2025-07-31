@extends('layouts.app')

@section('content')
<h2>作業の編集</h2>

<form action="{{ route('works.update', $work) }}" method="POST" enctype="multipart/form-data" class="work-form">
    @csrf
    @method('PUT')

    <div>
        <label>作業日:</label> <!-- 日本語 -->
        <input type="date" name="work_date" value="{{ old('work_date', $work->work_date ?? '') }}">
        @error('work_date') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>天気:</label>
        <select name="weather">
            <option value="">選択してください</option>
            <option value="晴れ" {{ old('weather', $work->weather) == '晴れ' ? 'selected' : '' }}>晴れ</option>
            <option value="曇り" {{ old('weather', $work->weather) == '曇り' ? 'selected' : '' }}>曇り</option>
            <option value="雨" {{ old('weather', $work->weather) == '雨' ? 'selected' : '' }}>雨</option>
            <option value="雪" {{ old('weather', $work->weather) == '雪' ? 'selected' : '' }}>雪</option>
        </select>
        @error('weather') <div class="error">{{ $message }}</div> @enderror
    </div>


    <div>
        <label>作物名:</label> <!-- 日本語 -->
        <input type="text" name="crops" value="{{ old('crops', $work->crops ?? '') }}">
        @error('crops') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>作業内容:</label> <!-- 日本語 -->
        <input type="text" name="work_details" value="{{ old('work_details', $work->work_details ?? '') }}">
        @error('work_details') <div class="error">{{ $message }}</div> @enderror
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


    <div class="actions">
        <button type="submit" class="btn">更新</button>
        <a href="{{ route('works.index') }}" class="btn">一覧に戻る</a>
    </div>

</form>
@endsection