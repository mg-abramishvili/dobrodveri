@php
    $popularProducts = json_decode($popularProducts, true);
@endphp

<div class="container pt-1 pb-1">
    <h5 class="title-header title-header-center">Популярные позиции</h5>

    <div class="category-products-list">
        @each('product-list-item', $popularProducts, 'product')
    </div>
</div>