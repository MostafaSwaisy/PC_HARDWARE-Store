<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->string('search')->toString().'%');
            })
            ->orderBy('name')
            ->paginate((int) $request->input('per_page', 15));

        return response()->json($categories);
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::query()->create($request->validated());

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category->loadCount('products'),
        ], Response::HTTP_CREATED);
    }

    public function show(int $category): JsonResponse
    {
        $item = Category::query()->withCount('products')->findOrFail($category);

        return response()->json([
            'category' => $item,
        ]);
    }

    public function update(UpdateCategoryRequest $request, int $category): JsonResponse
    {
        $item = Category::query()->findOrFail($category);
        $item->update($request->validated());

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => $item->loadCount('products'),
        ]);
    }

    public function destroy(int $category): JsonResponse
    {
        $item = Category::query()->withCount('products')->findOrFail($category);

        if ($item->products_count > 0) {
            return response()->json([
                'message' => 'Category cannot be deleted while products are linked to it.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item->delete();

        return response()->json([
            'message' => 'Category deleted successfully.',
        ]);
    }
}
