<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->isAdmin() && $request->route()->getName() === 'admin.news.index') {
            $news = News::latest()->paginate(20);
            return view('news.admin_index', compact('news'));
        }

        $news = News::where('is_published', true)
            ->where(function($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->paginate(10);

        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $disk = config('filesystems.images', 'public');
            $validated['image'] = $request->file('image')->store('news', $disk);
        }

        $validated['is_published'] = $request->has('is_published');

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'ニュースを登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        if (!$news->is_published) {
            abort(404);
        }

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $disk = config('filesystems.images', 'public');
            if ($news->image) {
                Storage::disk($disk)->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', $disk);
        }

        $validated['is_published'] = $request->has('is_published');

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'ニュースを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->image) {
            $disk = config('filesystems.images', 'public');
            Storage::disk($disk)->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'ニュースを削除しました。');
    }
}
