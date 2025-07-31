@extends('layouts.app')

@section('content')
<h2>作業の詳細</h2>

<div class="work-detail">
    <p><strong>作業日：</strong>{{ $work->work_date }}</p>
    <p><strong>天気：</strong>{{ $work->weather }}</p>
    <p><strong>作物：</strong>{{ $work->crops }}</p>
    <p><strong>作業内容:</strong>{{ $work->work_details }}</p>
    <p><strong>作業時間（分）:</strong>{{ $work->work_time }}</p>
    <p><strong>内容：</strong></p>
    <p>{!! nl2br(e($work->content)) !!}</p>
<!-- 作業写真 -->
    @if($work->image_path)
        <div class="work-image">
            <img src="{{ asset('storage/' . $work->image_path) }}" alt="作業画像">
        </div>
    @endif
</div>

<div class="actions">
    <a href="{{ route('works.edit', $work->id) }}">編集する</a>
    <a href="{{ route('works.index') }}">一覧に戻る</a>
</div>
@endsection