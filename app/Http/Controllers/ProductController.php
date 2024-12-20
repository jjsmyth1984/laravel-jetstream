<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

        // Get all product records
        $products = Product::all();

        // Return JSON response
        return response()->json($products);

    }

    /**
     * Display a listing of the resource.
     */
    public function userIndex(int $userId): JsonResponse
    {

        // Get all records against a specified user id
        $products = Product::where('user_id', $userId)
            ->orderBy('id')
            ->get();

        // Return JSON response
        return response()->json($products);

    }

    /**
     * Display the specified resource.
     */
    public function createProduct(Request $request, Product $product): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'int'],
            'title' => ['required', 'string', 'min:4', 'max:255'],
            'description' => ['required', 'string', 'min:6', 'max:2550'],
            'colour' => ['required', 'string', 'min:3', 'max:35'],
            'vat' => ['required', 'numeric'],
            'price' => ['required', 'numeric']
        ]);

        // Return error response
        if ($validator->fails()) {
            return response()->json(['status' => false, 'response' => $validator->errors()]);
        }

        // Save and process validated fields
        $incomingFields = $validator->validated();
        foreach($incomingFields as $key => $value) {
            // If string strip any tags
            $incomingFields[$key] = is_string($value) ? strip_tags($value) : $value;
        }

        // Save record
        $newRecord = Product::create($incomingFields);

        // Return JSON response
        return response()->json(['status' => true, 'response' => $newRecord]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Product $product)
    {
        //
    }
}
