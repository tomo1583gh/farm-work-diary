@extends('layouts.app')

@section('container-class', 'main-container')

@section('content')
<h2>作業一覧</h2>

<!-- 左：作業追加ボタン -->
<div class="mb-3 d-flex gap-2 align-items-center button-group">
    <a href="{{ route('works.create') }}" class="btn btn-success">＋ 新しい作業を追加</a>

    <!-- 右：カレンダー+CSｖボタン (横並び)-->
    <a href="{{ route('works.calendar') }}" class="btn btn-outline-secondary">カレンダー表示</a>

    <form method="GET" action="{{ route('works.export') }}">
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
        <button type="submit" class="btn btn-success">CSVエクスポート</button>
    </form>
</div>

@if(session('message'))
<div class="flash-message">{{ session('message') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>作業日</th>
            <th>天気</th>
            <th>作物名</th>
            <th>作業内容</th>
            <th>作業時間（分）</th>
            <th>詳細</th>
            <th>画像</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($works as $work)
        <tr>
            <td>{{ $work->work_date }}</td>
            <td> @switch($work->weather)
                @case('晴れ')
                <span class="weather sunny">☀ 晴れ</span>
                @break
                @case('曇り')
                <span class="weather cloudy">☁ 曇り</span>
                @break
                @case('雨')
                <span class="weather rainy">☔ 雨</span>
                @break
                @case('雪')
                <span class="weather snowy">❄ 雪</span>
                @break
                @default
                <span class="weather">-</span>
                @endswitch
            </td>
            <td>{{ $work->crops }}</td>
            <td>{{ $work->category_name }}</td>
            <td>{{ $work->work_time }}</td>
            <td>
                <a href="{{ route('works.show', $work->id) }}">{{ $work->crops }}</a>
            </td>
            <td>
                @if($work->image_path)
                <img src="{{ asset('storage/' . $work->image_path) }}" alt="作業画像" class="work-image">
                @endif
            </td>

            <td>
                <a href="{{ route('works.edit', $work) }}">編集</a>
                <form action="{{ route('works.destroy', $work) }}" method="POST" class="operation">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $works->appends(request()->query())->links() }}
</div>
@endsection