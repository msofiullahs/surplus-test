<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $images = Image::all();

        return response()->json($images, Response::HTTP_OK);
    }

    public function store($id = null, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'  => 'string',
            'file'  => 'base64_image',
            'enable'=> 'boolean'
        ]);
        if (empty($id)) {
            $validate = Validator::make($request->all(), [
                'name'  => 'required|string',
                'file'  => 'required|base64_image',
                'enable'=> 'required|boolean'
            ]);
        }

        if ($validate->fails()) {
            return response()->json($validate->messages(), Response::HTTP_BAD_REQUEST);
        }

        $img = $request->file;
        $ext = explode('/', mime_content_type($img))[1];
        $imgName = "image-".time().".".$ext;
        $value = base64_decode($img);
        Storage::disk('product-images')->put($imgName, $value);
        $imgPath = public_path('storage/product-images/'.$imgName);

        if (!empty($id)) {
            $image = Image::find($id)->update([
                'name'  => $request->name,
                'file'  => $imgPath,
                'enable'=> $request->enable
            ]);
        } else {
            $image = Image::create([
                'name'  => $request->name,
                'file'  => $imgPath,
                'enable'=> $request->enable
            ]);
        }

        if ($request->has('products')) {
            $image->products()->sync($request->products);
        }

        return response()->json($image, Response::HTTP_CREATED);
    }

    public function delete($id)
    {
        $image = Image::find($id);
        $image->products()->detach();
        $image->delete();
        return response()->json(['message'=>'Image is deleted'], Response::HTTP_ACCEPTED);
    }
}
