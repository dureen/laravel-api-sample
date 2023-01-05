<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // $products = Product::latest()->paginate(5);
        $products = Product::all();
        return new ProductResource(true, 'List Data Products', $products);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'   => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);
        $name = $request->name;
        $price = $request->price;

        $product = Product::create([
            'name'     => $name,
            'price'   => $price,
        ]);

        return new ProductResource(true, 'Product  Data was successfully added!', $product);
    }

    /**
     * show
     *
     * @param  mixed $product
     * @return void
     */
    public function show($id)
    {
        $product = Product::find($id);
        if(! $product) return new ProductResource(false, 'Not Found', 'null');
        return new ProductResource(true, 'Product data', $product);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'price'   => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 422);

        $product->update([
            'name'     => $request->name,
            'price'   => $request->price,
        ]);

        return new ProductResource(true, 'Product data was successfully updated!', $product);
    }

    /**
     * destroy
     *
     * @param  mixed $product
     * @return void
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return new ProductResource(true, 'Product data was successfully deleted!', null);
    }

}

