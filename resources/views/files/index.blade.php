@extends('layout')

@section('content')
    @include('site-menu')
    @include('files.list')
@endsection

@section('extraScripts')
    <script src="{{ URL::asset('js/files.js') . env('STATIC_FILE_VERSION') }}"></script>
@endsection