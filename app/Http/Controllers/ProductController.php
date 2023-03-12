<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        return response()->json($products, Response::HTTP_OK);
    }

    public function store($id = null, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'string',
            'description'   => 'string',
            'enable'        => 'boolean'
        ]);
        if (empty($id)) {
            $validate = Validator::make($request->all(), [
                'name'          => 'required|string',
                'description'   => 'required|string',
                'enable'        => 'required|boolean'
            ]);
        }

        if ($validate->fails()) {
            return response()->json($validate->messages(), Response::HTTP_BAD_REQUEST);
        }

        if (!empty($id)) {
            $product = Product::find($id)->update([
                'name'          => $request->name,
                'description'   => $request->description,
                'enable'        => $request->enable
            ]);
        } else {
            $product = Product::create([
                'name'          => $request->name,
                'description'   => $request->description,
                'enable'        => $request->enable
            ]);
        }

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        if ($request->has('images')) {
            $product->images()->sync($request->images);
        }

        return response()->json($product, Response::HTTP_CREATED);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->categories()->detach();
        $product->delete();
        return response()->json(['message'=>'Product is deleted'], Response::HTTP_ACCEPTED);
    }
}
