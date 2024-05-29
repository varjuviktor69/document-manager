<div class="categories-container">
    <ul class="categories-list init-list">
        <li data-category-slug="{{ $defaultCategory->slug }}" data-id="{{ $defaultCategory->id }}" data-name="{{ $defaultCategory->name }}">
            {{ $defaultCategory->name }}
            <span class="close-indicator">&#9655</span>
            <span class="open-indicator hidden">&#9661;</span>
            <ul class="categories-list"></ul>
        </li>
    </ul>
</div>
<h3 class="selected-category">Selected category: {{ $defaultCategory->name }}</h3>