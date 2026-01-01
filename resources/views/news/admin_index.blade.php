@extends('layouts.app')

@section('title', 'ニュース管理')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>ニュース管理</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> 新規登録
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>画像</th>
                            <th>タイトル</th>
                            <th>公開日</th>
                            <th>公開状態</th>
                            <th>作成日</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="news__thumbnail">
                                @else
                                    <div class="news__thumbnail news__image--placeholder d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image image-placeholder__icon"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($item->title, 50) }}</td>
                            <td>{{ $item->published_at ? $item->published_at->format('Y年m月d日') : '-' }}</td>
                            <td>
                                @if($item->is_published)
                                    <span class="badge bg-success">公開中</span>
                                @else
                                    <span class="badge bg-secondary">非公開</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('Y年m月d日') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> 編集
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('このニュースを削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> 削除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">ニュースが登録されていません。</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
