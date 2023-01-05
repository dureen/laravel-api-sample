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
        $data = new ProductResource(true, 'List of product.', $products);
        return response()->json($data);
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

        $data = new ProductResource(true, 'Created.', $product);
        return response()->json($data, 201);
    }

    /**
     * show
     *
     * @param  mixed $product
     * @return void
     */
    public function show($id=null)
    {
        $product = Product::find($id);
        if(! $product) {
            $data = new ProductResource(false, 'Not Found', 'null');
            return response()->json($data, 404);
        }
        $data = new ProductResource(true, 'Product.', $product);
        return response()->json($data);
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

        $data = new ProductResource(true, 'Updated.', $product);
        return response()->json($data);
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
        $data = new ProductResource(true, 'Deleted.', null);
        return response()->json($data);
    }

}

