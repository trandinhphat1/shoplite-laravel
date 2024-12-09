<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }
            return $next($request);
        });
    }

    public function getDashboardStats()
    {
        try {
            // Lấy thống kê đơn hàng
            $totalOrders = Order::where('status', 'done')->count();
            $totalRevenue = Order::where('status', 'done')
                ->where('is_paid', true)
                ->sum('total_amount');

            // Lấy thống kê sản phẩm
            $totalProducts = Product::count();
            $totalUsers = User::where('role', '!=', 'admin')->count();

            // Lấy đơn hàng mới nhất
            $recentOrders = Order::with(['user'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'total_amount' => $order->total_amount,
                        'status' => $order->status,
                        'created_at' => $order->created_at,
                        'customer_name' => $order->user ? $order->user->name : 'Unknown'
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'total_orders' => $totalOrders,
                    'total_revenue' => $totalRevenue,
                    'total_products' => $totalProducts,
                    'total_users' => $totalUsers,
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
}
