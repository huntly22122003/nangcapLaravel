<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\DTOs\OrderDTO;
use App\Services\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'search']);
        $perPage = $request->input('per_page', 20);

        $orders = $this->orderService->getOrders($filters, $perPage);
        return response()->json($orders);
    }

    public function show($id)
    {
        try {
            $order = $this->orderService->getOrder($id);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Không tìm thấy đơn hàng'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
                'status' => 'nullable|string|in:new,processing,completed,cancelled',
                'note' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'nullable|exists:products,id',
                'items.*.product_name' => 'required|string|max:255',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
            ]);

            // Tính tổng tiền
            $total = 0;
            foreach ($validated['items'] as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            $dto = new OrderDTO([
                'customer_id' => $validated['customer_id'],
                'status' => $validated['status'] ?? 'new',
                'total_amount' => $total,
                'note' => $validated['note'] ?? null,
            ]);

            $order = $this->orderService->createOrder($dto);

            // Tạo order items
            foreach ($validated['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Load lại với items
            $order->load('items');

            return response()->json($order, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
                'status' => 'nullable|string|in:new,processing,completed,cancelled',
                'total_amount' => 'nullable|numeric|min:0',
                'note' => 'nullable|string',
            ]);

            $dto = new OrderDTO($validated);
            $order = $this->orderService->updateOrder($id, $dto);

            return response()->json($order);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Lỗi máy chủ: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->orderService->deleteOrder($id);
            return response()->json(['message' => 'Xóa đơn hàng thành công']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:new,processing,completed,cancelled',
            ]);

            $order = $this->orderService->updateOrderStatus($id, $validated['status']);
            return response()->json($order);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}