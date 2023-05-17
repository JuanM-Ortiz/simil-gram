<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20'],
        ]);

        if($request->image) {
            $image = $request->file('image');

            $imageName = Str::uuid() . "." . $image->extension();

            $serverImage = Image::make($image);
            $serverImage->fit(1000, 1000);

            $pathImage = public_path('profiles') . "/" . $imageName;
            $serverImage->save($pathImage);
        }

        //Save Changes
        $user = User::find(auth()->user()->id);
        $user->username = $request->username;
        $user->image = $imageName ?? auth()->user()->image ?? null;
        $user->save();

        //Redirect
        return redirect()->route('posts.index', $user->username);
    }
}
