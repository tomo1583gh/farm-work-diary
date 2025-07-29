@extends('layouts.app')

@section('head')
<!-- FullCalendarのCSS（CDN） -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('content')
<h2>作業カレンダー</h2>
<div id="calendar"></div>

<!-- モーダルHTML-->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <h3 id="modal-title"></h3>
        <p><strong>日付：</strong> <span id="modal-date"></span></p>
        <p><strong>カテゴリ：</strong> <span id="modal-category"></span></p>
        <p><strong>天気：</strong> <span id="modal-weather"></span></p>
        <p><strong>内容：</strong></p>
        <p id="modal-content"></p>

        <!-- ✅ 作業画像（あれば表示） -->
        <div id="modal-image-wrapper">
            <img id="modal-image" src="" alt="作業画像">
        </div>

        <!-- ✅ 編集ボタン -->
        <a id="edit-link" href="#" class="edit-button">編集する</a>

        <!-- ✅ 削除フォーム（JavaScriptで動的にURLをセット） -->
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button" onclick="return confirm('本当に削除しますか？')">削除</button>
        </form>

        <button class="close-button" onclick="document.getElementById('eventModal').style.display = 'none'">閉じる</button>
    </div>
</div>

@endsection

@section('scripts')
<!-- FullCalendarのJS（CDN） -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ja', // 日本語表示
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },

            eventClick: function(info) {
                document.getElementById('modal-title').textContent = info.event.title;
                document.getElementById('modal-date').textContent = info.event.startStr;
                document.getElementById('modal-category').textContent = info.event.extendedProps.category || '-';
                document.getElementById('modal-weather').textContent = info.event.extendedProps.weather || '-';
                document.getElementById('modal-content').textContent = info.event.extendedProps.content || '-';

                // ✅ 編集リンクに動的URLをセット
                const editUrl = `/works/${info.event.id}/edit`;
                document.getElementById('edit-link').setAttribute('href', editUrl);

                // ✅ 画像表示処理
                const imageElement = document.getElementById('modal-image');
                const imageUrl = info.event.extendedProps.image_url;

                if (imageElement) {
                    if (imageUrl && typeof imageUrl === 'string') {
                        imageElement.src = imageUrl;
                        imageElement.style.display = 'block';
                    } else {
                        imageElement.removeAttribute('src');
                        imageElement.style.display = 'none';
                    }
                }

                // ✅ 削除フォームURLを設定
                const deleteForm = document.getElementById('delete-form');
                deleteForm.setAttribute('action', `/works/${info.event.id}`);

                document.getElementById('eventModal').style.display = 'block';
            },

            events: function(fetchInfo, successCallback, failureCallback) {
                fetch('/works/events')
                    .then(response => response.json())
                    .then(events => {
                        successCallback(events);
                    })
                    .catch(error => {
                        console.error('イベント取得失敗:', error);
                        failureCallback(error);
                    });
            },
            eventDidMount: function(info) {
                // デバッグ用：consoleで確認
                console.log('Event rendered:', info.event.title, info.event.backgroundColor);
            }
        });

        calendar.render();
    });
</script>
@endsection