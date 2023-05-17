@extends('layouts.app')

@section('title')
    Pagina Principal
@endsection

@section('content')
    
    <x-list-posts :posts="$posts"/>

@endsection