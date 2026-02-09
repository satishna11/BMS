<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * List all categories
     */
    public function index()
    {
        $categories = Category::orderBy('category_id', 'DESC')->get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    /**
     * Show single category
     */
    public function show($id)
    {
        $category = Category::where('category_id', $id)->firstOrFail();

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    /**
     * Load form (if needed for web)
     */
    public function form($id = null)
    {
        $category = null;

        if ($id) {
            $category = Category::where('category_id', $id)->firstOrFail();
        }

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    /**
     * Create or Update Category
     */
    public function saveCategory(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|integer', // optional for update
            'name' => 'required|string|max:100',
        ]);

        // CREATE
        if (!isset($validated['id']) || $validated['id'] == 0) {
            $category = Category::create([
                'name' => $validated['name'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Category created successfully!',
                'data' => $category
            ], 201);
        }

        // UPDATE
        $category = Category::where('category_id', $validated['id'])->first();

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $category->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully!',
            'data' => $category
        ], 200);
    }


    /**
     * Delete category
     */
    public function destroy($id)
    {
        $category = Category::where('category_id', $id)->firstOrFail();
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully!'
        ]);
    }
}
