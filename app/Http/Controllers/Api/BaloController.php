<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Thêm model của bạn
use DB;

class BaloController extends Controller
{
    public function index()
    {
        try {
            $products = DB::table('products')->get(); // hoặc Product::all() nếu bạn có model
            
            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 