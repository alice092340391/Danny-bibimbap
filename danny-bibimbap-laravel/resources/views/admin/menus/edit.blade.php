@extends('layouts.admin')

@section('title', '編輯菜單')

@section('content')
    <h1>編輯：{{ $menu->name }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.menus.update', $menu) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">餐點名稱</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">餐點描述</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $menu->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">價格</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $menu->price) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">分類</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ old('category', $menu->category) }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">狀態</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="radio" name="is_available" id="is_available_true" value="1" @checked(old('is_available', $menu->is_available))>
                        <label class="form-check-label" for="is_available_true">上架 (可點餐)</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="radio" name="is_available" id="is_available_false" value="0" @checked(!old('is_available', $menu->is_available))>
                        <label class="form-check-label" for="is_available_false">下架 (暫不提供)</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">儲存更新</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">取消</a>
            </form>
        </div>
    </div>
@endsection
