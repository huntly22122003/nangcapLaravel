<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer', 'items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return response()->json($orders);
    }

    public function show($id)
    {
        $order = Order::with('customer', 'items.product')->findOrFail($id);
        return response()->json($order);
    }
}