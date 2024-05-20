@props([
    'method' => 'POST',
    'action',
])

<form action="{{ $action }}" method="POST">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <input type="" placeholder="Category name" name="categoryName">
    <button>Save</button>
</form>