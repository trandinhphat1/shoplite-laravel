<?php

namespace App\Http\Controllers;

use App\Models\Balo;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BaloController extends Controller
{
    public function index(Request $request)
    {
        $query = Balo::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $balos = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $balos
        ]);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $searchTerm = $request->name;
        $balos = Balo::where('name', 'LIKE', "%{$searchTerm}%")->get();

        return response()->json([
            'success' => true,
            'data' => $balos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $balo = Balo::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Balo created successfully',
            'data' => $balo
        ], 201);
    }

    public function show($id)
    {
        $balo = Balo::find($id);
        
        if (!$balo) {
            return response()->json([
                'success' => false,
                'message' => 'Balo not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $balo
        ]);
    }

    public function update(Request $request, $id)
    {
        $balo = Balo::find($id);

        if (!$balo) {
            return response()->json([
                'success' => false,
                'message' => 'Balo not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'price' => 'numeric',
            'description' => 'string',
            'image' => 'nullable|string',
            'category_id' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $balo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Balo updated successfully',
            'data' => $balo
        ]);
    }

    public function destroy($id)
    {
        $balo = Balo::find($id);

        if (!$balo) {
            return response()->json([
                'success' => false,
                'message' => 'Balo not found'
            ], 404);
        }

        $balo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Balo deleted successfully'
        ]);
    }

    public function toggleFavorite($id)
    {
        $balo = Balo::find($id);
        
        if (!$balo) {
            return response()->json([
                'success' => false,
                'message' => 'Balo not found'
            ], 404);
        }

        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
                          ->where('balo_id', $id)
                          ->first();

        if ($favorite) {
            // If already favorited, remove from favorites
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Removed from favorites',
                'is_favorite' => false
            ]);
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'balo_id' => $id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Added to favorites',
                'is_favorite' => true
            ]);
        }
    }

    public function getFavorites()
    {
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)
                           ->with('balo')
                           ->get()
                           ->pluck('balo');

        return response()->json([
            'success' => true,
            'data' => $favorites
        ]);
    }

    public function checkFavorite($id)
    {
        $user = Auth::user();
        $isFavorite = Favorite::where('user_id', $user->id)
                             ->where('balo_id', $id)
                             ->exists();

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite
        ]);
    }
}