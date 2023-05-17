<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {

        //Validation
        $this->validate($request, [
            'comment' => ['required', 'max:255'],
        ]);

        //Insert in DB
        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comment' => $request->comment,
        ]);

        //Print Message
        return back()->with('message', 'Comentario Realizado Correctamente');
    }
}
