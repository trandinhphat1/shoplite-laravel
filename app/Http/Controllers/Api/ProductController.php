<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function getAllProductList()
    {
        $products = \App\Models\Product::where('status', 'active')
            ->select([
                'id', 'code', 'title', 'photo', 
                'summary', 'description', 'stock',
                'price_in', 'price_avg', 'price_out', 'price',
                'size', 'weight', 'status'
            ])
            ->get();
            
        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }
    public function getAllCat(){
        $cats = \App\Models\Category::where('status','active')->get();
        return response()->json([
            'success' => true,
            'products' => json_encode($cats),
        ], 200);
    }
    public function getProductCat(Request $request)
    {
        $id = $request->cat_id;
        $products = \App\Models\Product::where('cat_id',$id)->where('status','active')->get();
        return response()->json([
            'success' => true,
            'products' => json_encode($products),
        ], 200);
    }
}
