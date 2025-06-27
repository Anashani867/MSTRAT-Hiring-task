<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'status' => 'required|in:Active,Inactive',
        'amount' => 'required|numeric',
        'currency' => 'required|string|max:3',
    ]);

    $product = new \App\Models\Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->status = $request->status;
    $product->amount = $request->amount;
    $product->currency = $request->currency;
    $product->save();

    return response()->json(['message' => 'Product added successfully', 'data' => $product]);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    return Product::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'amount' => 'required|numeric',
        'currency' => 'required|string',
        'status' => 'in:Active,OutOfStock,inactive'
    ]);

    $product->update($request->all());

    return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return response()->json(['message' => 'Product deleted successfully']);
}

}
