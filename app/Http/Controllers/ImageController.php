<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file('file');

        $imageName = Str::uuid() . "." . $image->extension();

        $serverImage = Image::make($image);
        $serverImage->fit(1000, 1000);

        $pathImage = public_path('uploads') . "/" . $imageName;
        $serverImage->save($pathImage);

        return response()->json(['image' => $imageName]);
    }
}
