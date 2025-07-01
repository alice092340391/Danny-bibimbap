@extends('layouts.manage')

@section('title', '儀表板')

@section('content')
<div id="home" class="dashboard active">
    <div class="card">
        <h3>今日訂單數量</h3>
        <p>{{ $orderCount }}</p>
    </div>
    <div class="card">
        <h3>新增客戶數</h3>
        <p>{{ $newCustomers }}</p>
    </div>
    <div class="card">
        <h3>待處理訂單</h3>
        <p>{{ $pendingOrders }}</p>
    </div>
    </div>
@endsection