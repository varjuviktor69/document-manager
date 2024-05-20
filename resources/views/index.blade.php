@extends('layout')

@section('content')
    @include('site-menu')
    @include('categories.list')
@endsection

@section('extraScripts')
    <script>
        const DEFAULT_CATEGORY = @json($defaultCategory);
    </script>
    <script src="{{ URL::asset('js/categories.js') . env('STATIC_FILE_VERSION') }}"></script>
    <script src="{{ URL::asset('js/home.js') . env('STATIC_FILE_VERSION') }}"></script>
@endsection
