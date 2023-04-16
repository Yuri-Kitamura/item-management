@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
<h1>商品一覧</h1>
@stop

@section('content')
<!-- 検索機能ここから -->
<div class="d-flex justify-content-end mb-3">
    <form method="GET" action="">
        @csrf
        <input type="text" name="keyword">
        <input type="submit" value="検索">
    </form>
</div>
<!-- 検索機能ここまで -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">商品一覧</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <div class="input-group-append">
                            <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>名前</th>
                            <th>種別</th>
                            <th>詳細</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <td>
                                <span class="detail-text">{{ $item->detail }}</span>
                                <button type="button" class="btn btn-info small-button" data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}">詳細</button>
                            </td>
                            <td>
                                <a href="{{ route('item.edit', $item->id) }}" class=" btn btn-primary small-button">編集</a>
                                <form action="{{ route('item.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('本当に削除しますか？')" class="btn btn-danger small-button">削除</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal Component -->
                        <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modal-{{ $item->id }}-label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 text-center" id="modal-{{ $item->id }}-label">{{ $item->name }}</h5>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>【ID】{{ $item->id }}</p>
                                        <p>【種別】<br> {{ $item->type }}</p>
                                        <p>【詳細】<br> {{ $item->detail }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
                <!-- ページネーション -->
                <div class="d-flex justify-content-center">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop