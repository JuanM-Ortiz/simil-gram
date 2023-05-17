@extends('layouts.app')

@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->image }}" alt="Image Post {{ $post->title }}">

            <div class="p-3 flex items-center gap-4">
                @auth

                    <livewire:like-post :post="$post" />

                @endauth
                        
            </div>
            

            <div>
                {{-- <p class="font-bold">
                    {{ $post->user->username }}
                </p>
                --}}
                <a class="font-bold" href="{{ route('posts.index', $user) }}">{{ $post->user->username }}</a>

                <p class="text-sm text-gray-600">
                    {{ $post->created_at->diffForHumans() }}
                </p>

                <p class="md:w-1/2">
                    {{ $post->description }}
                </p>

                @auth

                    @if ($post->user_id === auth()->user()->id)

                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                            {{-- SPOOFING METHOD --}}
                            @method('DELETE')

                            @csrf

                            <input 
                                type="submit"
                                value="Eliminar Publicacion"
                                class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer"
                            />

                        </form>  

                    @endif     

                @endauth
                
            </div>
        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                @guest

                    <p class="bg-red-500 text-white uppercase my-2 rounded-lg text-md p-2 text-center">Debes Iniciar Sesion Para Comentar o Dar Me Gusta</p>
                
                @endguest

                @auth
                
                    <p class="text-xl font-bold text-center mb-4">
                        Agrega un comentario
                    </p>

                    @if (session('message'))

                        <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                            {{ session('message') }}
                        </div>

                    @endif

                    <form action="{{ route('comment.store', ['post' => $post, 'user' => $user]) }}" method="POST">

                        @csrf

                        <div class="mb-5">
                            <label for="comment" class="mb-2 block uppercase text-gray-500 font-bold">Añade un Comentario</label>
                            <textarea 
                                id="comment" 
                                name="comment" 
                                placeholder="Escribe un comentario" 
                                class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror" 
                            ></textarea>

                            @error('comment')

                                <p class="bg-red-500 text-white my-2 rounded-lg text-lg p-2 text-center">{{ $message }}</p>

                            @enderror

                        </div>

                        <input 
                            type="submit" 
                            value="Comentar" 
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                        />
                    </form>
                @endauth

                <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">

                    @if ($post->comments->count())

                        @foreach ($post->comments as $comment)

                            <div class="p-5 border-gray-400 border-b">
                                <a class="font-bold" href="{{ route('posts.index', $comment->user) }}">
                                    {{ $comment->user->username }}
                                </a>

                                <p>{{ $comment->comment }}</p>

                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>

                        @endforeach

                    @else

                        <p class="p-10 text-center">No Hay Comentarios Aun</p>

                    @endif
                    
                </div>

            </div>
        </div>
    </div>
@endsection