@extends('layouts.admin')

@section('title', '新增菜單')

@section('content')
    <h1>新增菜單</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.menus.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">餐點名稱</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">餐點描述</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">價格</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">分類</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{ old('category', '主餐') }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">狀態</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="radio" name="is_available" id="is_available_true" value="1" @checked(old('is_available', true))>
                        <label class="form-check-label" for="is_available_true">上架 (可點餐)</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="radio" name="is_available" id="is_available_false" value="0" @checked(!old('is_available', true))>
                        <label class="form-check-label" for="is_available_false">下架 (暫不提供)</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">建立新菜單</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">取消</a>
            </form>
        </div>
    </div>
@endsection
