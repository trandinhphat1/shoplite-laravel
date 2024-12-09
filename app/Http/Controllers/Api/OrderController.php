<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getOrderCount()
    {
        try {
            $user = auth()->user();
            $query = Order::query();
            
            if (!$user->isAdmin()) {
                $query->where('customer_id', $user->id);
            }
            
            $orderCount = $query->count();
            
            return response()->json([
                'status' => 'success',
                'data' => [
                    'total_orders' => $orderCount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể lấy số đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $order = Order::find($request->order_id);
            
            if (!auth()->user()->isAdmin() && auth()->id() !== $order->customer_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền thanh toán đơn hàng này'
                ], 403);
            }

            // Tự động tạo ship_id và invoice_id
            $ship_id = time() . rand(1000, 9999);
            $invoice_id = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);

            // Cập nhật trực tiếp bằng query builder
            DB::table('orders')
                ->where('id', $request->order_id)
                ->update([
                    'shiptrans_id' => $ship_id,
                    'paidtrans_id' => $invoice_id,
                    'is_paid' => true,
                    'status' => 'done'
                ]);

            // Lấy thông tin đơn hàng sau khi cập nhật
            $updatedOrder = Order::find($request->order_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Thanh toán đơn hàng thành công',
                'data' => [
                    'order' => $updatedOrder,
                    'ship_id' => $ship_id,
                    'invoice_id' => $invoice_id
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể thanh toán đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completePayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|exists:orders,id',
                'ship_id' => 'required',
                'invoice_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $order = Order::find($request->order_id);
            
            if (!auth()->user()->isAdmin() && auth()->id() !== $order->customer_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền thanh toán đơn hàng này'
                ], 403);
            }

            // Cập nhật trực tiếp bằng query builder
            DB::table('orders')
                ->where('id', $request->order_id)
                ->update([
                    'shiptrans_id' => $request->ship_id,
                    'paidtrans_id' => $request->invoice_id,
                    'is_paid' => true,
                    'status' => 'done'
                ]);

            // Lấy thông tin đơn hàng sau khi cập nhật
            $updatedOrder = Order::find($request->order_id);

            return response()->json([
                'status' => 'success',
                'message' => 'Thanh toán đơn hàng thành công',
                'data' => [
                    'order' => $updatedOrder
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể thanh toán đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }
}
