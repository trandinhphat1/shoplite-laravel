<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getStatistics()
    {
        try {
            $user = auth()->user();
            
            // Lấy tất cả đơn hàng của user
            $orders = Order::where('customer_id', $user->id);
            
            // Tính toán thống kê
            $stats = [
                'total_orders' => $orders->count(),
                'completed_orders' => $orders->where('status', 'done')->count(),
                'pending_orders' => $orders->where('status', 'pending')->count(),
                'total_spent' => $orders->where('status', 'done')
                    ->where('is_paid', true)
                    ->sum('total_amount'),
                'loyalty_points' => $user->loyalty_points ?? 0
            ];

            // Lấy 5 đơn hàng gần nhất
            $recentOrders = Order::where('customer_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($order) {
                    return [
                        'id' => $order->id,
                        'total_amount' => $order->total_amount,
                        'status' => $order->status,
                        'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                        'is_paid' => $order->is_paid
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'statistics' => $stats,
                    'recent_orders' => $recentOrders
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể lấy thống kê: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validatedData = $request->validate([
                'full_name' => 'sometimes|string|max:255',
                'phone' => 'sometimes|string|max:20',
                'address' => 'sometimes|string|max:255',
                'description' => 'sometimes|string',
                'photo' => 'sometimes|string',
                'taxcode' => 'sometimes|string',
                'taxname' => 'sometimes|string',
                'taxaddress' => 'sometimes|string',
            ]);

            $user->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
