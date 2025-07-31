<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Work::where('user_id', auth()->id());

        // キーワード検索
        if ($request->filled('keyword')) {
            $keyword = mb_convert_kana(trim($request->keyword), 's');
            $query->where(function ($q) use ($keyword) {
                $q->where('crops', 'like', "%{$keyword}%")
                    ->orWhere('work_details', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            });
        }
        // 期間検索
        if ($request->filled('start_date')) {
            $query->whereDate('work_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('work_date', '<=', $request->end_date);
        }

        $works = $query->latest()->paginate(10);

        return view('works.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('works.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('works', 'public');
        }

        $validated['user_id'] = auth()->id();

        Work::create($validated);

        return redirect()->route('works.index')->with('message', '作業を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work = Work::where('user_id', auth()->id())->findOrFail($id);
        return view('works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $work = Work::where('user_id', auth()->id())->findOrFail($id);
        return view('works.edit', compact('work'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkRequest $request, $id)
    {
        $validated = $request->validated();

        $work = Work::where('user_id', auth()->id())->findOrFail($id);

        // ★ 元画像削除 + 新画像保存
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($work->image_path && Storage::disk('public')->exists($work->image_path)) {
                Storage::disk('public')->delete($work->image_path);
            }
            // 新しい画像を保存
            $validated['image_path'] = $request->file('image')->store('works', 'public');
        }

        $work->update($validated);

        return redirect()->route('works.index')->with('message', '作業を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $work = Work::where('user_id', auth()->id())->findOrFail($id);
        $work->delete();

        return redirect()->route('works.index')->with('message', '作業を削除しました');
    }

    public function calendar()
    {
        return view('works.calendar');
    }

    public function events()
    {
        $works = Work::where('user_id', auth()->id())->get();

            // カテゴリに応じた色分け設定
            $colorMap = [
                '草刈り' => '#28a745', // 緑
                '収穫' => '#ffc107', // 黄
                '播種' => '#007bff', // 青
                '施肥' => '#dc3545', // 赤
                '束ね' => '#17a2b8', // シアン
                // その他のカテゴリーに対応する色
                'その他' => '#6c757d', // グレー
            ];

            $events = $works->map(function ($work) use ($colorMap) {
                // カテゴリ名を正規化(前後の空白・全角半角の違いを吸収)
                $categoryRaw = $work->work_details ?? 'その他';
                $work_details = mb_convert_kana(trim($categoryRaw), 's'); // 全角->半角スペース変換

            $color = $colorMap[$work_details] ?? '#999999';

            return [
                'id' => $work->id,
                'title' => $work->crops,
                'crops' => $work->crops,
                'start' => $work->work_date,
                'work_details' => $work->work_details,
                'content' => $work->content,
                'weather' => $work->weather,
                'work_time' => $work->work_time,
                'image_url' => $work->image_path ? asset('storage/' . $work->image_path) : null,
                'backgroundColor' => $color,
                'borderColor' => $color,

            ];
        });

        return response()->json($events);
    }

    public function export(Request $request)
    {
        $query = Work::where('user_id', auth()->id());

        $work = $query->get();

        $response = new StreamedResponse(function () use ($work) {
            $handle = fopen('php://output', 'w');

            // ヘッダー
            $headers = ['ID', '作物名', '日付', '作業内容', '作業時間', '内容', '天気'];
            $headers = array_map(fn($val) => mb_convert_encoding($val, 'SJIS-win', 'UTF-8'), $headers);
            fputcsv($handle, $headers);

            foreach ($work as $item) {
                $row = [
                    $item->id,
                    $item->crops,
                    $item->work_date,
                    $item->work_details,
                    $item->content,
                    $item->weather,
                    $item->work_time,
                ];
                $row = array_map(fn($val) => mb_convert_encoding($val, 'SJIS-win', 'UTF-8'), $row);
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=Shift_JIS');
        $response->headers->set('Content-Disposition', 'attachment; filename="works_export.csv"');

        return $response;
    }
}
