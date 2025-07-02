@extends('layouts.admin')

@section('title', '訂單管理')

@section('content')
    <h1>訂單管理</h1>
    <p>顯示最新的訂單。</p>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>訂單ID</th>
                        <th>桌號</th>
                        <th>總金額</th>
                        <th>狀態</th>
                        <th>下單時間</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->OrderID }}</td>
                            <td>{{ $order->tableNumber }}</td>
                            <td>NT$ {{ number_format($order->totalPrice) }}</td>
                            <td><span class="badge bg-warning">{{ $order->orderStatus }}</span></td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" type="button" data-bs-toggle="collapse" data-bs-target="#order-{{ $order->OrderID }}">
                                    查看
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse" id="order-{{ $order->OrderID }}">
                            <td colspan="6">
                                <div class="p-3 bg-light">
                                    <h5>訂單內容：</h5>
                                    <ul>
                                        @foreach ($order->items as $item)
                                            <li>{{ $item->item_name }} x {{ $item->quantity }} (單價: ${{ number_format($item->price) }})</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">目前沒有任何訂單。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
