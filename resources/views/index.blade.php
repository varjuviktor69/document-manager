@extends('layout')

@section('content')
    @include('site-menu')
    @include('categories.list')
    @include('files.list')
@endsection

@section('extraScripts')
    <script>
        const DEFAULT_CATEGORY = @json($defaultCategory);
        const DEFAULT_FILES = @json($files);
        const FILE_BY_CATEGORY_ROUTE = "{{ route('files.by-category', ['categoryId' => ':categoryId']) }}";
    </script>
    <script src="{{ URL::asset('js/categories.js') . env('STATIC_FILE_VERSION') }}"></script>
    <script src="{{ URL::asset('js/home.js') . env('STATIC_FILE_VERSION') }}"></script>
@endsection
