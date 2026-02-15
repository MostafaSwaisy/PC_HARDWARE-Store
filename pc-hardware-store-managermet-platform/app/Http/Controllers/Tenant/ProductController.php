<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::query()
            ->with(['category:id,name', 'supplier:id,name'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%')
                        ->orWhere('brand', 'like', '%'.$search.'%');
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', (int) $request->input('category_id')))
            ->when($request->filled('supplier_id'), fn ($query) => $query->where('supplier_id', (int) $request->input('supplier_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')->toString()))
            ->latest('id')
            ->paginate((int) $request->input('per_page', 15));

        return response()->json($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated())->load(['category:id,name', 'supplier:id,name']);

        return response()->json([
            'message' => 'Product created successfully.',
            'product' => $product,
        ], Response::HTTP_CREATED);
    }

    public function show(int $product): JsonResponse
    {
        $item = Product::query()
            ->with(['category:id,name', 'supplier:id,name'])
            ->findOrFail($product);

        return response()->json([
            'product' => $item,
        ]);
    }

    public function update(UpdateProductRequest $request, int $product): JsonResponse
    {
        $item = Product::query()->findOrFail($product);
        $item->update($request->validated());
        $item->load(['category:id,name', 'supplier:id,name']);

        return response()->json([
            'message' => 'Product updated successfully.',
            'product' => $item,
        ]);
    }

    public function destroy(int $product): JsonResponse
    {
        $item = Product::query()->findOrFail($product);
        $item->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
