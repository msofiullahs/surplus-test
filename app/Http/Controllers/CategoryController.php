<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        return response()->json($categories, Response::HTTP_OK);
    }

    public function store($id = null, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'      => 'string',
            'enable'    => 'boolean'
        ]);
        if (empty($id)) {
            $validate = Validator::make($request->all(), [
                'name'      => 'required|string',
                'enable'    => 'required|boolean'
            ]);
        }

        if ($validate->fails()) {
            return response()->json($validate->messages(), Response::HTTP_BAD_REQUEST);
        }

        if (!empty($id)) {
            $category = Category::find($id)->update([
                'name'=> $request->name,
                'enable'=> $request->enable
            ]);
        } else {
            $category = Category::create([
                'name'=> $request->name,
                'enable'=> $request->enable
            ]);
        }

        if ($request->has('products')) {
            $category->products()->sync($request->products);
        }

        return response()->json($category, Response::HTTP_CREATED);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->products()->detach();
        $category->delete();
        return response()->json(['message'=>'Category is deleted'], Response::HTTP_ACCEPTED);
    }
}
