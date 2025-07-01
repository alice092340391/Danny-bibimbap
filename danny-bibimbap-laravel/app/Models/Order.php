<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'OrderID';

    protected $fillable = [
        'tableNumber',
        'totalPrice',
        'orderStatus',
        'customerName',
        'customerPhone',
        'menuChoices',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'OrderID');
    }
}
