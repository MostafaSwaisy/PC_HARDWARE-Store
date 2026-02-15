<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $suppliers = Supplier::query()
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->string('search')->toString();
                $query->where(function ($inner) use ($term) {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.$term.'%')
                        ->orWhere('phone', 'like', '%'.$term.'%');
                });
            })
            ->orderBy('name')
            ->paginate((int) $request->input('per_page', 15));

        return response()->json($suppliers);
    }

    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::query()->create($request->validated());

        return response()->json([
            'message' => 'Supplier created successfully.',
            'supplier' => $supplier->loadCount('products'),
        ], Response::HTTP_CREATED);
    }

    public function show(int $supplier): JsonResponse
    {
        $item = Supplier::query()->withCount('products')->findOrFail($supplier);

        return response()->json([
            'supplier' => $item,
        ]);
    }

    public function update(UpdateSupplierRequest $request, int $supplier): JsonResponse
    {
        $item = Supplier::query()->findOrFail($supplier);
        $item->update($request->validated());

        return response()->json([
            'message' => 'Supplier updated successfully.',
            'supplier' => $item->loadCount('products'),
        ]);
    }

    public function destroy(int $supplier): JsonResponse
    {
        $item = Supplier::query()->withCount('products')->findOrFail($supplier);

        if ($item->products_count > 0) {
            return response()->json([
                'message' => 'Supplier cannot be deleted while products are linked to it.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $item->delete();

        return response()->json([
            'message' => 'Supplier deleted successfully.',
        ]);
    }
}
