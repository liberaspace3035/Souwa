@extends('layouts.app')

@section('title', 'ニュース管理')

@section('content')
<div class="admin-page">
    <div class="container my-5">
        <!-- ページヘッダー -->
        <div class="admin-page__header">
            <div class="admin-page__header-content">
                <div class="admin-page__title-section">
                    <h1 class="admin-page__title">
                        ニュース管理
                    </h1>
                    <p class="admin-page__subtitle">ニュースの登録・編集・削除を行います</p>
                </div>
                <a href="{{ route('admin.news.create') }}" class="btn btn-create">
                    新規登録
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="admin-page__alert alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- ニュース一覧テーブル -->
        <div class="admin-page__content">
            @if($news->count() > 0)
            <div class="admin-table">
                <div class="admin-table__header">
                    <div class="admin-table__info">
                        <span>全{{ $news->total() }}件</span>
                    </div>
                </div>
                <div class="admin-table__body">
                    <table class="admin-table__table">
                        <thead>
                            <tr>
                                <th class="admin-table__th admin-table__th--id">ID</th>
                                <th class="admin-table__th admin-table__th--image">画像</th>
                                <th class="admin-table__th admin-table__th--title">タイトル</th>
                                <th class="admin-table__th admin-table__th--published">公開日</th>
                                <th class="admin-table__th admin-table__th--status">公開状態</th>
                                <th class="admin-table__th admin-table__th--created">作成日</th>
                                <th class="admin-table__th admin-table__th--actions">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                            <tr class="admin-table__row">
                                <td class="admin-table__td admin-table__td--id">{{ $item->id }}</td>
                                <td class="admin-table__td admin-table__td--image">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="admin-table__thumbnail">
                                    @else
                                        <div class="admin-table__thumbnail admin-table__thumbnail--placeholder">
                                        </div>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--title">
                                    @if($item->link)
                                        <a href="{{ $item->link }}" class="admin-table__link" target="_blank">
                                            {{ Str::limit($item->title, 50) }}
                                        </a>
                                    @else
                                        <a href="{{ route('news.show', $item->id) }}" class="admin-table__link" target="_blank">
                                            {{ Str::limit($item->title, 50) }}
                                        </a>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--published">
                                    @if($item->published_at)
                                        <span class="admin-table__date">{{ $item->published_at->format('Y年m月d日') }}</span>
                                    @else
                                        <span class="admin-table__empty">未設定</span>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--status">
                                    @if($item->is_published)
                                        <span class="admin-table__status admin-table__status--published">
                                            公開中
                                        </span>
                                    @else
                                        <span class="admin-table__status admin-table__status--draft">
                                            非公開
                                        </span>
                                    @endif
                                </td>
                                <td class="admin-table__td admin-table__td--created">
                                    <span class="admin-table__date">{{ $item->created_at->format('Y年m月d日') }}</span>
                                </td>
                                <td class="admin-table__td admin-table__td--actions">
                                    <div class="admin-table__actions">
                                        <a href="{{ route('admin.news.edit', $item) }}" class="admin-table__action-btn admin-table__action-btn--edit" title="編集">
                                            編集
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="admin-table__action-form" onsubmit="return confirm('このニュースを削除しますか？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-table__action-btn admin-table__action-btn--delete" title="削除">
                                                削除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="admin-table__footer">
                    <div class="admin-table__pagination">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="admin-empty">
                <div class="admin-empty__content">
                    <h3 class="admin-empty__title">ニュースが登録されていません</h3>
                    <p class="admin-empty__message">新規登録ボタンからニュースを追加してください</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-create">
                        新規登録
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
