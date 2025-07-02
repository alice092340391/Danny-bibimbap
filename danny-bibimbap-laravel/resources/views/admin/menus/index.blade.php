@extends('layouts.admin')

@section('title', '菜單管理')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>菜單管理</h1>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-success">
            <i class="fa-solid fa-plus me-1"></i> 新增菜單
        </a>
    </div>
    <p>管理店內所有餐點的資訊與狀態。</p>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>名稱</th>
                        <th>分類</th>
                        <th>價格</th>
                        <th>狀態</th>
                        <th class="text-end">操作</th> 
                    </tr>
                </thead>
                <tbody>

                    @foreach ($menus as $menu)
                        <tr>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->category }}</td>
                            <td>NT$ {{ number_format($menu->price) }}</td>
                            <td>
                                @if ($menu->is_available)
                                    <span class="badge bg-success">上架中</span>
                                @else
                                    <span class="badge bg-secondary">已下架</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-primary">編輯</a>
                                
                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('您確定要刪除「{{ $menu->name }}」嗎？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
