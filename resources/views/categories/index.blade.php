@extends('layout')

@section('content')
    @include('site-menu')
    @include('categories.list')
    <button class="create-btn">Add Subcategory</button>
    <button class="edit-btn">Edit</button>
    <button class="delete-btn">Delete</button>
    <div class="edit-form hidden">
        Edit category
        @include('categories.form', [
            'method' => 'PUT',
            'action' => route('categories.edit', ['id' => $defaultCategory->id]),
        ])
    </div>
    <div class="create-form hidden">
        Add sub category
        @include('categories.form', [
            'action' => route('categories.create', ['parentId' => ':parentId']),
        ])
    </div>
    @include('files.form')
@endsection

@section('extraScripts')
    <script>
        const DELETE_ROUTE = "{{ route('categories.delete', ['id' => ':id']) }}";
        const EDIT_ROUTE = "{{ route('categories.edit', ['id' => ':id']) }}";
        const CREATE_ROUTE = "{{ route('categories.create', ['parentId' => ':parentId']) }}";
        const DEFAULT_CATEGORY = @json($defaultCategory);
        const CSRF_TOKEN = '{{ csrf_token() }}';
    </script>
    <script src="{{ URL::asset('js/categories.js') . env('STATIC_FILE_VERSION') }}"></script>
    <script src="{{ URL::asset('js/files.js') . env('STATIC_FILE_VERSION') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setDefaultFormActions();
            createCategoryTree(DEFAULT_CATEGORY);
            handleOpenAndCloseCategories();
            handleButtons();
        });
    </script>
@endsection